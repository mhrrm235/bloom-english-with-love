@extends('layouts.app')

@section('title', 'Dashboard Admin - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Welcome Header -->
    <div class="gradient-brand rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-10 flex items-center justify-center">
            <span class="text-9xl font-black">👑</span>
        </div>
        <div class="relative z-10">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Control Panel</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 tracking-tight">Selamat Datang, Administrator!</h1>
            <p class="mt-2 text-rose-100 text-sm sm:text-base max-w-2xl">
                Kelola pengguna, kursus, webinar, dan pantau perkembangan platform Bloom English with Love secara real-time.
            </p>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stat 1 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 bg-emerald-100 text-emerald-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Student</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $stats['total_students'] }}</h3>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 bg-indigo-100 text-indigo-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Instructor</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $stats['total_instructors'] }}</h3>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 bg-rose-100 text-rose-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Course</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $stats['total_courses'] }}</h3>
            </div>
        </div>

        <!-- Stat 4 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-4 bg-purple-100 text-purple-600 rounded-2xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Webinar</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $stats['total_webinars'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Management Quick Actions -->
    <div class="flex flex-wrap gap-4 mb-10">
        <a href="{{ route('admin.users.index') }}" class="px-5 py-3 rounded-2xl bg-purple-600 text-white font-bold text-sm shadow-md hover:bg-purple-700 transition-all flex items-center space-x-2">
            <span>👥 Kelola Seluruh User</span>
        </a>
        <a href="{{ route('courses.create') }}" class="px-5 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm shadow-md hover:bg-slate-800 transition-all flex items-center space-x-2">
            <span>➕ Buat Course Baru</span>
        </a>
        <a href="{{ route('webinars.create') }}" class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-bold text-sm shadow-md hover:bg-rose-700 transition-all flex items-center space-x-2">
            <span>🌐 Buat Webinar Baru</span>
        </a>
    </div>

    <!-- Recent Content Grids -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Courses List -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-extrabold text-slate-900">📚 Course Terbaru</h2>
                <a href="{{ route('courses.index') }}" class="text-xs font-bold text-rose-600 hover:underline">Kelola Semua &rarr;</a>
            </div>

            <div class="space-y-4">
                @forelse($recentCourses as $course)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-rose-100 text-rose-700">{{ $course->level }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $course->title }}</h4>
                        <p class="text-xs text-slate-500">Instructor: {{ $course->instructor->name }}</p>
                    </div>
                    <a href="{{ route('courses.show', $course->slug) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100">
                        Detail
                    </a>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada course yang dibuat.</p>
                @endforelse
            </div>
        </div>

        <!-- Webinars List -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-extrabold text-slate-900">🌐 Webinar Terbaru</h2>
                <a href="{{ route('webinars.index') }}" class="text-xs font-bold text-rose-600 hover:underline">Kelola Semua &rarr;</a>
            </div>

            <div class="space-y-4">
                @forelse($recentWebinars as $webinar)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-purple-100 text-purple-700">
                            {{ $webinar->schedule_time->format('d M Y, H:i') }} WIB
                        </span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $webinar->title }}</h4>
                        <p class="text-xs text-slate-500">Host: {{ $webinar->instructor->name }}</p>
                    </div>
                    <a href="{{ route('webinars.show', $webinar->slug) }}" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-100">
                        Detail
                    </a>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Belum ada webinar yang dijadwalkan.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
