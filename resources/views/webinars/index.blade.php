@extends('layouts.app')

@section('title', 'Jadwal Webinar - Bloom English with Love')

@section('content')
<div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">🌐 Jadwal Webinar Pembelajaran</h1>
            <p class="text-sm text-slate-600 mt-1">Ikuti sesi interaktif langsung bersama pengajar profesional bahasa Inggris.</p>
        </div>

        @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isInstructor()))
        <a href="{{ route('webinars.create') }}" class="px-5 py-3 rounded-2xl bg-rose-600 text-white font-bold text-sm shadow-md hover:bg-rose-700 transition-all flex items-center space-x-2">
            <span>➕ Buat Webinar Baru</span>
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($webinars as $webinar)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold px-3 py-1 rounded-full bg-purple-100 text-purple-700">
                        {{ strtoupper($webinar->status) }}
                    </span>
                    <span class="text-xs text-slate-400 font-medium">⏱️ {{ $webinar->duration_minutes }} Mins</span>
                </div>

                <h3 class="text-lg font-extrabold text-slate-900 leading-snug">{{ $webinar->title }}</h3>
                <p class="text-xs text-slate-600 mt-2 line-clamp-3">{{ $webinar->description }}</p>

                <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-600">
                    <div class="flex items-center space-x-2">
                        <span>📅</span>
                        <span class="font-bold">{{ $webinar->schedule_time->format('d M Y - H:i') }} WIB</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span>👤</span>
                        <span>Host: <strong>{{ $webinar->instructor->name }}</strong></span>
                    </div>
                </div>
            </div>

            <div class="p-6 pt-0">
                <a href="{{ route('webinars.show', $webinar->slug) }}" class="w-full flex justify-center py-3 px-4 rounded-2xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800 transition-all">
                    Lihat Detail & Link Akses
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-white rounded-3xl border border-slate-100 shadow-xs">
            <p class="text-slate-500 font-medium">Belum ada webinar yang dijadwalkan.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
