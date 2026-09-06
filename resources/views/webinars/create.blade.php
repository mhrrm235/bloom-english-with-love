@extends('layouts.app')

@section('title', 'Tambah Webinar Baru - Bloom English with Love')

@section('content')
<div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-6">➕ Buat Jadwal Webinar Baru</h1>

        <form action="{{ route('webinars.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700">Judul Webinar</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Mastering English Pronunciation Live"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
                @error('title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Deskripsi Webinar</label>
                <textarea name="description" rows="4" required placeholder="Jelaskan topik dan manfaat yang didapatkan peserta..."
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700">Jadwal & Waktu Pelaksanaan</label>
                    <input type="datetime-local" name="schedule_time" required value="{{ old('schedule_time') }}"
                        class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
                    @error('schedule_time') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700">Durasi (Menit)</label>
                    <input type="number" name="duration_minutes" required value="{{ old('duration_minutes', 60) }}" min="15"
                        class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
                    @error('duration_minutes') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Tautan Akses Virtual Meeting (Zoom / Google Meet)</label>
                <input type="url" name="meeting_link" required value="{{ old('meeting_link') }}" placeholder="https://zoom.us/j/123456789"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
                <p class="text-[11px] text-slate-400 mt-1">*Tautan ini akan dilindungi dan hanya dapat dilihat oleh peserta terdaftar.</p>
                @error('meeting_link') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Kapasitas Maksimal Peserta (Opsional)</label>
                <input type="number" name="max_participants" value="{{ old('max_participants', 100) }}" placeholder="100"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-rose-500">
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('webinars.index') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl gradient-brand text-white font-bold text-sm shadow-md hover:opacity-95">
                    Simpan Webinar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
