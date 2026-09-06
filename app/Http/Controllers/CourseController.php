<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\CourseMaterial;

class CourseController extends Controller
{
    /**
     * Katalog Course
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $courses = Course::with('instructor')
                ->where('is_published', true)
                ->latest()
                ->get();
        } else {
            $query = Course::with('instructor')->withCount('students', 'materials');
            if ($user->isInstructor()) {
                $query->where('instructor_id', $user->id);
            }
            $courses = $query->latest()->get();
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Form Tambah Course Baru
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Simpan Course Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'level' => ['required', 'in:Beginner,Intermediate,Advanced'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('courses', 'public');
        }

        $course = Course::create([
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
            'level' => $request->level,
            'thumbnail' => $thumbnailPath,
            'is_published' => true,
        ]);

        return redirect()->route('courses.show', $course->slug)->with('success', 'Course berhasil dibuat! Silakan tambahkan materi modul.');
    }

    /**
     * Detail Course & Akses Materi
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        $isEnrolled = false;

        if ($user) {
            $isEnrolled = $course->students()->where('user_id', $user->id)->exists();
        }

        $canManage = $user && ($user->isAdmin() || $user->id === $course->instructor_id);
        $materials = $course->materials;

        return view('courses.show', compact('course', 'materials', 'isEnrolled', 'canManage'));
    }

    /**
     * Form Edit Course
     */
    public function edit(Course $course)
    {
        $this->authorizeOwnerOrAdmin($course);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update Course
     */
    public function update(Request $request, Course $course)
    {
        $this->authorizeOwnerOrAdmin($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'level' => ['required', 'in:Beginner,Intermediate,Advanced'],
            'is_published' => ['required', 'boolean'],
        ]);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level,
            'is_published' => $request->is_published,
        ]);

        return redirect()->route('courses.show', $course->slug)->with('success', 'Informasi course berhasil diperbarui.');
    }

    /**
     * Hapus Course
     */
    public function destroy(Course $course)
    {
        $this->authorizeOwnerOrAdmin($course);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course berhasil dihapus.');
    }

    /**
     * Pendaftaran (Enrollment) Course oleh Student
     */
    public function enroll(Course $course)
    {
        $user = Auth::user();

        $course->students()->syncWithoutDetaching([
            $user->id => ['enrolled_at' => now(), 'status' => 'active']
        ]);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Selamat! Anda telah terdaftar di kursus ini. Silakan akses modul pembelajaran.');
    }

    /**
     * Tambah Materi Modul Baru
     */
    public function storeMaterial(Request $request, Course $course)
    {
        $this->authorizeOwnerOrAdmin($course);

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'video_url' => ['nullable', 'url'],
            'file_attachment' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'order_sequence' => ['required', 'integer', 'min:1'],
        ]);

        $filePath = null;
        if ($request->hasFile('file_attachment')) {
            $filePath = $request->file('file_attachment')->store('materials', 'public');
        }

        CourseMaterial::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'file_attachment' => $filePath,
            'order_sequence' => $request->order_sequence,
        ]);

        return redirect()->route('courses.show', $course->slug)->with('success', 'Materi modul baru berhasil ditambahkan.');
    }

    /**
     * Lihat Isi Materi Modul (Khusus Peserta Terdaftar / Instructor / Admin)
     */
    public function showMaterial(Course $course, CourseMaterial $material)
    {
        $user = Auth::user();
        $isEnrolled = $course->students()->where('user_id', $user->id)->exists();
        $canManage = $user->isAdmin() || $user->id === $course->instructor_id;

        if (!$isEnrolled && !$canManage) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Anda harus mendaftar kursus ini terlebih dahulu untuk membuka materi.');
        }

        $allMaterials = $course->materials;

        return view('courses.material', compact('course', 'material', 'allMaterials'));
    }

    /**
     * Hapus Materi Modul
     */
    public function destroyMaterial(CourseMaterial $material)
    {
        $course = $material->course;
        $this->authorizeOwnerOrAdmin($course);
        
        $material->delete();

        return redirect()->route('courses.show', $course->slug)->with('success', 'Materi modul berhasil dihapus.');
    }

    /**
     * Helper Authorization
     */
    protected function authorizeOwnerOrAdmin(Course $course)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && $user->id !== $course->instructor_id) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah kursus ini.');
        }
    }
}
