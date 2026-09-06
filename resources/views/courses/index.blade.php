@extends('layouts.app')

@section('title', 'Katalog Course - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">📚 Katalog Course Pembelajaran</h1>
            <p class="text-sm text-slate-600 mt-1">Pilih materi modul pembelajaran berkualitas sesuai tingkat kemampuan Anda.</p>
        </div>

        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isInstructor()))
        <a href="{{ route('courses.create') }}" class="px-5 py-3 rounded-2xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700 transition-all flex items-center space-x-2">
            <span>➕ Tambah Course Baru</span>
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-700">
                        {{ strtoupper($course->level) }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">Instructor: {{ $course->instructor->name }}</span>
                </div>

                <h3 class="text-lg font-extrabold text-slate-900 leading-snug">{{ $course->title }}</h3>
                <p class="text-xs text-slate-600 mt-2 line-clamp-3">{{ $course->description }}</p>
            </div>

            <div class="p-6 pt-0">
                <a href="{{ route('courses.show', $course->slug) }}" class="w-full flex justify-center py-3 px-4 rounded-2xl gradient-brand text-white text-xs font-bold shadow-xs hover:opacity-95 transition-all">
                    Lihat Modul & Pelajari
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-slate-100 shadow-xs">
            <p class="text-slate-500 font-medium">Belum ada course yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
