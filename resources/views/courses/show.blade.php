@extends('layouts.app')

@section('title', $course->title . ' - Bloom English with Love')

@section('content')
<div class="py-8 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <a href="{{ route('courses.index') }}" class="text-xs font-bold text-slate-500 hover:text-rose-600 mb-4 inline-block">&larr; Kembali ke Katalog Course</a>

    <!-- Course Overview Card -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8 mb-8">
        <div class="flex items-center justify-between gap-4 mb-4">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                LEVEL: {{ strtoupper($course->level) }}
            </span>
            <span class="text-xs font-semibold text-slate-500">Instructor: {{ $course->instructor->name }}</span>
        </div>

        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">{{ $course->title }}</h1>
        <p class="text-sm text-slate-600 leading-relaxed mb-6">{{ $course->description }}</p>

        <!-- Student Enrollment Banner / Button -->
        @auth
            @if(Auth::user()->isStudent())
                @if($isEnrolled)
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between text-sm">
                        <span class="font-bold">✅ Anda Telah Terdaftar di Kursus Ini</span>
                        <span class="text-xs font-semibold text-emerald-600">Akses Penuh Seluruh Modul</span>
                    </div>
                @else
                    <form action="{{ route('courses.enroll', $course->slug) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 px-6 rounded-2xl gradient-brand text-white font-extrabold text-sm shadow-md hover:opacity-95 transition-all">
                            Daftar Kursus Ini Sekarang (Gratis)
                        </button>
                    </form>
                @endif
            @endif
        @endauth
    </div>

    <!-- Modul Pembelajaran List -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">📖 Modul & Materi Pembelajaran</h2>
                <p class="text-xs text-slate-500 mt-0.5">Urutan materi disusun untuk pembelajaran terstruktur.</p>
            </div>

            @if($canManage)
            <button onclick="document.getElementById('add-material-modal').classList.toggle('hidden')" 
                class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700">
                ➕ Tambah Modul Baru
            </button>
            @endif
        </div>

        <!-- Material Add Modal Form for Instructor/Admin -->
        @if($canManage)
        <div id="add-material-modal" class="hidden mb-8 p-6 rounded-2xl bg-slate-50 border border-slate-200">
            <h3 class="text-sm font-extrabold text-slate-900 mb-4">Form Tambah Materi Modul Baru</h3>
            <form action="{{ route('courses.materials.store', $course->slug) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700">Judul Materi Modul</label>
                        <input type="text" name="title" required placeholder="Contoh: Lesson 1 - Speaking Strategy"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700">Urutan Sequence</label>
                        <input type="number" name="order_sequence" required value="{{ $materials->count() + 1 }}" min="1"
                            class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-xl text-xs">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Unggah File Modul Pembelajaran (PDF - Maks 10MB)</label>
                    <input type="file" name="file_attachment" accept="application/pdf"
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-xl text-xs bg-white">
                    <p class="text-[11px] text-slate-400 mt-1">*Pilih dokumen PDF pendukung untuk modul ini.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Tautan Video Pembelajaran (YouTube Embed URL - Opsional)</label>
                    <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..."
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-xl text-xs">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700">Isi Penjelasan Teks / Catatan Pembelajaran</label>
                    <textarea name="content" rows="3" placeholder="Tulis rincian materi atau instruksi di sini..."
                        class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-xl text-xs"></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('add-material-modal').classList.add('hidden')" 
                        class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 text-xs font-bold">Batal</button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700">Simpan Materi</button>
                </div>
            </form>
        </div>
        @endif

        <!-- Materials List -->
        <div class="space-y-3">
            @forelse($materials as $index => $material)
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 font-black text-sm flex items-center justify-center">
                        {{ $material->order_sequence }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                            <span>{{ $material->title }}</span>
                            @if($material->file_attachment)
                            <span class="px-2 py-0.5 rounded-md bg-red-100 text-red-700 text-[10px] font-extrabold flex items-center gap-1">
                                📑 PDF File
                            </span>
                            @endif
                        </h4>
                        <span class="text-[11px] text-slate-400">
                            {{ $material->video_url ? '🎥 Modul Video & Teks' : ($material->file_attachment ? '📑 Dokumen PDF Pembelajaran' : '📄 Modul Catatan Teks') }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    @if($isEnrolled || $canManage)
                    <a href="{{ route('courses.materials.show', [$course->slug, $material->id]) }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-rose-600 hover:bg-rose-50 shadow-2xs">
                        Buka Modul &rarr;
                    </a>
                    @else
                    <span class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>🔒</span> Terkunci
                    </span>
                    @endif

                    @if($canManage)
                    <form action="{{ route('materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-500 hover:text-rose-700 font-bold text-xs" title="Hapus Materi">&times;</button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-sm text-slate-400 text-center py-6">Belum ada materi modul yang ditambahkan ke kursus ini.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
