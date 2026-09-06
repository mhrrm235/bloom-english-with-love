@extends('layouts.app')

@section('title', 'Dashboard Saya - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Student Header Banner -->
    <div class="gradient-brand rounded-3xl p-8 text-white shadow-xl mb-10 relative overflow-hidden">
        <div class="relative z-10">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Student Dashboard</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 tracking-tight">Selamat Belajar, {{ Auth::user()->name }}! ❤️</h1>
            <p class="mt-2 text-rose-100 text-sm sm:text-base max-w-2xl">
                Tingkatkan terus keahlian bahasa Inggris Anda melalui course interaktif dan ikuti webinar eksklusif.
            </p>
        </div>
    </div>

    <!-- Section 1: Enrolled Courses & Registered Webinars -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        
        <!-- Enrolled Courses -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <span>📖 Course Saya</span>
                    <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">{{ $enrolledCourses->count() }}</span>
                </h2>
                <a href="{{ route('courses.index') }}" class="text-xs font-bold text-rose-600 hover:underline">Jelajahi Course &rarr;</a>
            </div>

            <div class="space-y-4">
                @forelse($enrolledCourses as $course)
                <div class="p-4 rounded-2xl bg-gradient-card border border-rose-100/60 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-rose-100 text-rose-700">{{ $course->level }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $course->title }}</h4>
                        <p class="text-xs text-slate-500">Instructor: {{ $course->instructor->name }}</p>
                    </div>
                    <a href="{{ route('courses.show', $course->slug) }}" class="px-4 py-2 rounded-xl gradient-brand text-white text-xs font-bold shadow-xs hover:opacity-95">
                        Lanjut Belajar
                    </a>
                </div>
                @empty
                <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-sm text-slate-500 font-medium">Anda belum mendaftar course apa pun.</p>
                    <a href="{{ route('courses.index') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-rose-600 text-white text-xs font-bold">
                        Pilih Course Sekarang
                    </a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Registered Webinars -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-extrabold text-slate-900 flex items-center gap-2">
                    <span>🎟️ Webinar Terdaftar</span>
                    <span class="px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 text-xs font-bold">{{ $registeredWebinars->count() }}</span>
                </h2>
                <a href="{{ route('webinars.index') }}" class="text-xs font-bold text-purple-600 hover:underline">Jadwal Webinar &rarr;</a>
            </div>

            <div class="space-y-4">
                @forelse($registeredWebinars as $webinar)
                <div class="p-4 rounded-2xl bg-slate-50 border border-purple-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-purple-100 text-purple-700">
                            📅 {{ $webinar->schedule_time->format('d M Y, H:i') }} WIB
                        </span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $webinar->title }}</h4>
                        <p class="text-xs text-slate-500">Host: {{ $webinar->instructor->name }}</p>
                    </div>
                    <a href="{{ route('webinars.show', $webinar->slug) }}" class="px-4 py-2 rounded-xl bg-purple-600 text-white text-xs font-bold hover:bg-purple-700 shadow-xs">
                        Buka Link Zoom
                    </a>
                </div>
                @empty
                <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-sm text-slate-500 font-medium">Anda belum mendaftar webinar.</p>
                    <a href="{{ route('webinars.index') }}" class="inline-block mt-3 px-4 py-2 rounded-xl bg-purple-600 text-white text-xs font-bold">
                        Lihat Jadwal Webinar
                    </a>
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Section 2: Recommendations (Available Webinars & Courses) -->
    <div class="mb-10">
        <h2 class="text-2xl font-extrabold text-slate-900 mb-6">🌟 Rekomendasi Webinar Mendatang</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($availableWebinars as $webinar)
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-rose-100 text-rose-700">
                            ⏰ {{ $webinar->schedule_time->format('d M Y, H:i') }} WIB
                        </span>
                        <span class="text-xs text-slate-400 font-medium">{{ $webinar->duration_minutes }} Menit</span>
                    </div>
                    <h3 class="text-lg font-extrabold text-slate-900">{{ $webinar->title }}</h3>
                    <p class="text-xs text-slate-600 mt-2 line-clamp-2">{{ $webinar->description }}</p>
                </div>
                <div class="mt-6 flex items-center justify-between pt-4 border-t border-slate-100">
                    <span class="text-xs text-slate-500 font-semibold">Host: {{ $webinar->instructor->name }}</span>
                    <a href="{{ route('webinars.show', $webinar->slug) }}" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800">
                        Daftar Webinar
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
