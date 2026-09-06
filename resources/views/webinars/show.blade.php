@extends('layouts.app')

@section('title', $webinar->title . ' - Bloom English with Love')

@section('content')
<div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <a href="{{ route('webinars.index') }}" class="text-xs font-bold text-slate-500 hover:text-rose-600 mb-4 inline-block">&larr; Kembali ke Daftar Webinar</a>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                STATUS: {{ strtoupper($webinar->status) }}
            </span>
            <span class="text-xs font-semibold text-slate-500">
                Durasi: {{ $webinar->duration_minutes }} Menit
            </span>
        </div>

        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">{{ $webinar->title }}</h1>
        <p class="text-sm text-slate-600 leading-relaxed mb-6">{{ $webinar->description }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/60 mb-8 text-sm">
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Waktu Pelaksanaan</p>
                <p class="font-bold text-slate-800 mt-0.5">📅 {{ $webinar->schedule_time->format('l, d F Y - H:i') }} WIB</p>
            </div>
            <div>
                <p class="text-xs text-slate-400 font-bold uppercase">Pengajar / Host</p>
                <p class="font-bold text-slate-800 mt-0.5">🎓 {{ $webinar->instructor->name }}</p>
            </div>
        </div>

        <!-- Protected Meeting Link Container -->
        <div class="p-6 rounded-2xl border-2 {{ $canAccessLink ? 'border-emerald-300 bg-emerald-50/50' : 'border-amber-300 bg-amber-50/50' }} mb-8">
            @if($canAccessLink)
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <span class="px-2.5 py-1 rounded-md bg-emerald-200 text-emerald-900 text-xs font-bold uppercase">Akses Tautan Terbuka</span>
                        <h4 class="font-extrabold text-slate-900 text-base mt-2">Link Sesi Virtual Webinar:</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Klik tombol di kanan untuk langsung bergabung ke ruang Zoom / Meet.</p>
                    </div>
                    <a href="{{ $webinar->meeting_link }}" target="_blank" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-md hover:bg-emerald-700 transition-all flex items-center space-x-2">
                        <span>🚀 Masuk ke Sesi Zoom</span>
                    </a>
                </div>
            @else
                <div class="text-center py-4">
                    <span class="text-3xl">🔒</span>
                    <h4 class="font-extrabold text-slate-900 text-base mt-2">Tautan Dikunci</h4>
                    <p class="text-xs text-slate-600 mt-1 max-w-md mx-auto">
                        Link Zoom/Google Meet hanya ditampilkan kepada peserta yang terdaftar secara resmi.
                    </p>
                </div>
            @endif
        </div>

        <!-- Registration Action Buttons -->
        @auth
            @if(Auth::user()->isStudent())
                @if($isRegistered)
                    <form action="{{ route('webinars.cancel', $webinar->slug) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran webinar ini?');">
                        @csrf
                        <button type="submit" class="w-full py-3.5 px-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 font-bold text-sm hover:bg-rose-100 transition-all">
                            Batalkan Pendaftaran Webinar
                        </button>
                    </form>
                @else
                    <form action="{{ route('webinars.register', $webinar->slug) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3.5 px-4 rounded-2xl gradient-brand text-white font-bold text-sm shadow-md hover:opacity-95 transition-all">
                            Daftar Sesi Webinar Sekarang (Gratis)
                        </button>
                    </form>
                @endif
            @endif

            @if(Auth::user()->isAdmin() || Auth::user()->id === $webinar->instructor_id)
                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('webinars.edit', $webinar->slug) }}" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-bold hover:bg-slate-200">
                        Edit Webinar
                    </a>
                    <form action="{{ route('webinars.destroy', $webinar->slug) }}" method="POST" onsubmit="return confirm('Hapus webinar ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-xl bg-rose-100 text-rose-700 text-xs font-bold hover:bg-rose-200">
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        @endauth

    </div>
</div>
@endsection
