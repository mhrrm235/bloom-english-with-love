@extends('layouts.app')

@section('title', 'Dashboard Instructor - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Instructor Welcome Header -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-700 to-rose-700 rounded-3xl p-8 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Instructor Portal</span>
            <h1 class="text-3xl sm:text-4xl font-extrabold mt-2 tracking-tight">Halo, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 text-indigo-100 text-sm sm:text-base max-w-2xl">
                Kelola materi pembelajaran, bagikan ilmu bahasa Inggris Anda, dan pantau partisipasi webinar peserta.
            </p>
        </div>
    </div>

    <!-- Instructor Quick Stats & Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Course Diampu</p>
            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $myCourses->count() }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Webinar Dijadwalkan</p>
            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $myWebinars->count() }}</h3>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Peserta Terdaftar</p>
            <h3 class="text-3xl font-black text-rose-600 mt-1">{{ $totalStudentsEnrolled }}</h3>
        </div>
    </div>

    <!-- Quick Action Buttons -->
    <div class="flex flex-wrap gap-4 mb-10">
        <a href="{{ route('courses.create') }}" class="px-5 py-3 rounded-2xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700 transition-all flex items-center space-x-2">
            <span>📚 Tambah Course Baru</span>
        </a>
        <a href="{{ route('webinars.create') }}" class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-bold text-sm shadow-md hover:bg-rose-700 transition-all flex items-center space-x-2">
            <span>🌐 Buat Jadwal Webinar</span>
        </a>
    </div>

    <!-- Instructor Content Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- My Courses -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900 mb-6">📚 Course yang Anda Kelola</h2>
            <div class="space-y-4">
                @forelse($myCourses as $course)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-indigo-100 text-indigo-700">{{ $course->level }}</span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $course->title }}</h4>
                        <p class="text-xs text-slate-500">👨‍🎓 {{ $course->students_count }} Student Terdaftar</p>
                    </div>
                    <a href="{{ route('courses.show', $course->slug) }}" class="px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700">
                        Kelola Modul
                    </a>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Anda belum mengampu course.</p>
                @endforelse
            </div>
        </div>

        <!-- My Webinars -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h2 class="text-lg font-extrabold text-slate-900 mb-6">🌐 Webinar yang Anda Djadwalkan</h2>
            <div class="space-y-4">
                @forelse($myWebinars as $webinar)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-rose-100 text-rose-700">
                            {{ $webinar->schedule_time->format('d M Y, H:i') }} WIB
                        </span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $webinar->title }}</h4>
                        <p class="text-xs text-slate-500">🎟️ {{ $webinar->participants_count }} Peserta Terdaftar</p>
                    </div>
                    <a href="{{ route('webinars.show', $webinar->slug) }}" class="px-3 py-1.5 rounded-xl bg-rose-600 text-white text-xs font-bold hover:bg-rose-700">
                        Detail Link
                    </a>
                </div>
                @empty
                <p class="text-sm text-slate-400 text-center py-4">Anda belum menjadwalkan webinar.</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
