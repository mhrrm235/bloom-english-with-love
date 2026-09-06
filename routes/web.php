<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\WebinarController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Bloom English with Love
|--------------------------------------------------------------------------
*/

// Landing Page Redirect / Public Welcome
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (Semua User Terautentikasi)
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- Admin Management Routes ---
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // Kelola User oleh Admin
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // --- Instructor Routes ---
    Route::middleware('role:instructor')->group(function () {
        Route::get('/instructor/dashboard', [DashboardController::class, 'instructorDashboard'])->name('instructor.dashboard');
    });

    // --- Student Routes ---
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', [DashboardController::class, 'studentDashboard'])->name('student.dashboard');
    });

    // --- Modul Webinar ---
    Route::get('/webinars', [WebinarController::class, 'index'])->name('webinars.index');
    Route::get('/webinars/{webinar:slug}', [WebinarController::class, 'show'])->name('webinars.show');

    // Webinar Management (Admin & Instructor)
    Route::middleware('role:admin,instructor')->group(function () {
        Route::get('/webinars-create', [WebinarController::class, 'create'])->name('webinars.create');
        Route::post('/webinars', [WebinarController::class, 'store'])->name('webinars.store');
        Route::get('/webinars/{webinar:slug}/edit', [WebinarController::class, 'edit'])->name('webinars.edit');
        Route::put('/webinars/{webinar:slug}', [WebinarController::class, 'update'])->name('webinars.update');
        Route::delete('/webinars/{webinar:slug}', [WebinarController::class, 'destroy'])->name('webinars.destroy');
    });

    // Student Webinar Action
    Route::middleware('role:student')->group(function () {
        Route::post('/webinars/{webinar:slug}/register', [WebinarController::class, 'register'])->name('webinars.register');
        Route::post('/webinars/{webinar:slug}/cancel', [WebinarController::class, 'cancelRegistration'])->name('webinars.cancel');
    });

    // --- Modul Course ---
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course:slug}/materials/{material}', [CourseController::class, 'showMaterial'])->name('courses.materials.show');

    // Course Management (Admin & Instructor)
    Route::middleware('role:admin,instructor')->group(function () {
        Route::get('/courses-create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course:slug}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course:slug}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course:slug}', [CourseController::class, 'destroy'])->name('courses.destroy');
        
        // Course Materials Management
        Route::post('/courses/{course:slug}/materials', [CourseController::class, 'storeMaterial'])->name('courses.materials.store');
        Route::delete('/materials/{material}', [CourseController::class, 'destroyMaterial'])->name('materials.destroy');
    });

    // Student Course Action
    Route::middleware('role:student')->group(function () {
        Route::post('/courses/{course:slug}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    });
});
