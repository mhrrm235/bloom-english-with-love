<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Webinar;
use App\Models\Role;

class DashboardController extends Controller
{
    /**
     * Dashboard khusus Role Admin
     */
    public function adminDashboard()
    {
        $stats = [
            'total_students' => User::whereHas('role', fn($q) => $q->where('name', 'student'))->count(),
            'total_instructors' => User::whereHas('role', fn($q) => $q->where('name', 'instructor'))->count(),
            'total_courses' => Course::count(),
            'total_webinars' => Webinar::count(),
        ];

        $recentCourses = Course::with('instructor')->latest()->take(5)->get();
        $recentWebinars = Webinar::with('instructor')->latest()->take(5)->get();
        $recentUsers = User::with('role')->latest()->take(5)->get();

        return view('dashboard.admin', compact('stats', 'recentCourses', 'recentWebinars', 'recentUsers'));
    }

    /**
     * Dashboard khusus Role Instructor
     */
    public function instructorDashboard()
    {
        $user = Auth::user();

        $myCourses = Course::where('instructor_id', $user->id)
            ->withCount('students')
            ->latest()
            ->get();

        $myWebinars = Webinar::where('instructor_id', $user->id)
            ->withCount('participants')
            ->latest()
            ->get();

        $totalStudentsEnrolled = $myCourses->sum('students_count');

        return view('dashboard.instructor', compact('myCourses', 'myWebinars', 'totalStudentsEnrolled'));
    }

    /**
     * Dashboard khusus Role Student
     */
    public function studentDashboard()
    {
        $user = Auth::user();

        // Course yang sedang/telah diikuti
        $enrolledCourses = $user->enrolledCourses()->with('instructor')->get();

        // Webinar yang telah didaftarkan
        $registeredWebinars = $user->registeredWebinars()->with('instructor')->get();

        // Webinar mendatang yang belum didaftarkan
        $availableWebinars = Webinar::whereNotIn('id', $registeredWebinars->pluck('id'))
            ->where('status', 'upcoming')
            ->where('schedule_time', '>=', now())
            ->with('instructor')
            ->latest()
            ->take(4)
            ->get();

        // Course rekomendasi yang belum diikuti
        $availableCourses = Course::whereNotIn('id', $enrolledCourses->pluck('id'))
            ->where('is_published', true)
            ->with('instructor')
            ->latest()
            ->take(4)
            ->get();

        return view('dashboard.student', compact(
            'enrolledCourses',
            'registeredWebinars',
            'availableWebinars',
            'availableCourses'
        ));
    }
}
