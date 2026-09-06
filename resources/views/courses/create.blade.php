@extends('layouts.app')

@section('title', 'Buat Course Baru - Bloom English with Love')

@section('content')
<div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
        <h1 class="text-2xl font-extrabold text-slate-900 mb-6">➕ Buat Course Pembelajaran Baru</h1>

        <form action="{{ route('courses.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-slate-700">Judul Course</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Mastering English Speaking"
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                @error('title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Tingkat Kesulitan (Level)</label>
                <select name="level" required class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="Beginner" {{ old('level') == 'Beginner' ? 'selected' : '' }}>Beginner (Dasar)</option>
                    <option value="Intermediate" {{ old('level') == 'Intermediate' ? 'selected' : '' }}>Intermediate (Menengah)</option>
                    <option value="Advanced" {{ old('level') == 'Advanced' ? 'selected' : '' }}>Advanced (Lanjutan)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700">Deskripsi Ringkas Course</label>
                <textarea name="description" rows="4" required placeholder="Jelaskan ringkasan materi pembelajaran dan target peserta..."
                    class="mt-1 block w-full px-4 py-3 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('courses.index') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm hover:bg-slate-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-md hover:bg-indigo-700">
                    Simpan Course
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
