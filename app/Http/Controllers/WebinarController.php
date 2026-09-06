<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Webinar;
use App\Models\WebinarRegistration;

class WebinarController extends Controller
{
    /**
     * Daftar Seluruh Webinar
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $webinars = Webinar::with('instructor')
                ->where('status', 'upcoming')
                ->orderBy('schedule_time', 'asc')
                ->get();
        } else {
            // Admin / Instructor
            $query = Webinar::with('instructor')->withCount('participants');
            if ($user->isInstructor()) {
                $query->where('instructor_id', $user->id);
            }
            $webinars = $query->latest()->get();
        }

        return view('webinars.index', compact('webinars'));
    }

    /**
     * Form Tambah Webinar (Admin / Instructor)
     */
    public function create()
    {
        return view('webinars.create');
    }

    /**
     * Simpan Webinar Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'schedule_time' => ['required', 'date', 'after:now'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'meeting_link' => ['required', 'url'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'banner_image' => ['nullable', 'image', 'max:2048'],
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('webinars', 'public');
        }

        Webinar::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'schedule_time' => $request->schedule_time,
            'duration_minutes' => $request->duration_minutes,
            'meeting_link' => $request->meeting_link,
            'max_participants' => $request->max_participants,
            'banner_image' => $bannerPath,
            'status' => 'upcoming',
        ]);

        return redirect()->route('webinars.index')->with('success', 'Jadwal Webinar berhasil dibuat!');
    }

    /**
     * Detail Webinar & Proteksi Akses Tautan
     */
    public function show(Webinar $webinar)
    {
        $user = Auth::user();
        $isRegistered = false;
        
        if ($user) {
            $isRegistered = $webinar->participants()->where('user_id', $user->id)->exists();
        }

        $canAccessLink = $user && ($user->isAdmin() || $user->id === $webinar->instructor_id || $isRegistered);

        return view('webinars.show', compact('webinar', 'isRegistered', 'canAccessLink'));
    }

    /**
     * Form Edit Webinar
     */
    public function edit(Webinar $webinar)
    {
        $this->authorizeOwnerOrAdmin($webinar);
        return view('webinars.edit', compact('webinar'));
    }

    /**
     * Update Webinar
     */
    public function update(Request $request, Webinar $webinar)
    {
        $this->authorizeOwnerOrAdmin($webinar);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'schedule_time' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'meeting_link' => ['required', 'url'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,live,completed,cancelled'],
        ]);

        $webinar->update([
            'title' => $request->title,
            'description' => $request->description,
            'schedule_time' => $request->schedule_time,
            'duration_minutes' => $request->duration_minutes,
            'meeting_link' => $request->meeting_link,
            'max_participants' => $request->max_participants,
            'status' => $request->status,
        ]);

        return redirect()->route('webinars.index')->with('success', 'Data Webinar berhasil diperbarui!');
    }

    /**
     * Hapus Webinar
     */
    public function destroy(Webinar $webinar)
    {
        $this->authorizeOwnerOrAdmin($webinar);
        $webinar->delete();

        return redirect()->route('webinars.index')->with('success', 'Webinar berhasil dihapus.');
    }

    /**
     * Pendaftaran Webinar oleh Student
     */
    public function register(Webinar $webinar)
    {
        $user = Auth::user();

        if ($webinar->max_participants && $webinar->participants()->count() >= $webinar->max_participants) {
            return back()->with('error', 'Maaf, kuota peserta webinar ini telah penuh.');
        }

        $webinar->participants()->syncWithoutDetaching([
            $user->id => ['registered_at' => now(), 'status' => 'registered']
        ]);

        return redirect()->route('webinars.show', $webinar->slug)
            ->with('success', 'Selamat! Anda berhasil mendaftar webinar ini. Link akses sekarang tersedia.');
    }

    /**
     * Pembatalan Pendaftaran Webinar oleh Student
     */
    public function cancelRegistration(Webinar $webinar)
    {
        $user = Auth::user();
        $webinar->participants()->detach($user->id);

        return redirect()->route('webinars.show', $webinar->slug)
            ->with('success', 'Pendaftaran webinar berhasil dibatalkan.');
    }

    /**
     * Authorization Helper
     */
    protected function authorizeOwnerOrAdmin(Webinar $webinar)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $user->id !== $webinar->instructor_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah webinar ini.');
        }
    }
}
