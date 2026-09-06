@extends('layouts.app')

@section('title', $material->title . ' - ' . $course->title)

@section('content')
<div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('courses.show', $course->slug) }}" class="text-xs font-bold text-slate-500 hover:text-rose-600">
            &larr; Kembali ke Modul Course {{ $course->title }}
        </a>
        <span class="text-xs font-bold px-3 py-1 bg-rose-100 text-rose-700 rounded-full">
            Modul Ke-{{ $material->order_sequence }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left: Course Materials Navigation Sidebar -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-slate-100 shadow-sm p-5 h-fit">
            <h3 class="font-extrabold text-slate-900 text-sm mb-4 border-b border-slate-100 pb-2">Daftar Modul Pembelajaran</h3>
            <div class="space-y-2">
                @foreach($allMaterials as $m)
                <a href="{{ route('courses.materials.show', [$course->slug, $m->id]) }}" 
                   class="block p-3 rounded-xl text-xs font-bold transition-all {{ $m->id === $material->id ? 'bg-rose-600 text-white shadow-xs' : 'bg-slate-50 text-slate-700 hover:bg-slate-100' }}">
                    <div class="flex items-center justify-between">
                        <span class="truncate"><span class="opacity-75 mr-1">#{{ $m->order_sequence }}</span> {{ $m->title }}</span>
                        @if($m->file_attachment)
                        <span class="text-[10px] ml-1">📑</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Right: Lesson Content Viewer -->
        <div class="lg:col-span-3 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-8">
                <h1 class="text-2xl font-extrabold text-slate-900 mb-2">{{ $material->title }}</h1>
                <p class="text-xs text-slate-400 font-semibold mb-6">Course: {{ $course->title }} | Instructor: {{ $course->instructor->name }}</p>

                <!-- PDF Document Download / Preview Section -->
                @if($material->file_attachment)
                <div class="mb-8 p-5 rounded-2xl bg-gradient-to-r from-rose-50 to-pink-50 border border-rose-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-xl bg-rose-600 text-white font-black text-xl flex items-center justify-center shadow-md">
                            📑
                        </div>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Dokumen Modul Pembelajaran PDF</h4>
                            <p class="text-xs text-slate-500">File materi resmi untuk diunduh atau dipelajari secara offline.</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($material->file_attachment) }}" target="_blank" download class="px-5 py-2.5 rounded-xl bg-rose-600 text-white font-extrabold text-xs shadow-md hover:bg-rose-700 transition-all flex items-center space-x-1.5 whitespace-nowrap">
                        <span>📥 Unduh File PDF</span>
                    </a>
                </div>

                <!-- Inline Embedded PDF Reader -->
                <div class="mb-8 border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="bg-slate-100 px-4 py-2 text-xs font-bold text-slate-600 border-b border-slate-200 flex justify-between items-center">
                        <span>Preview Dokumen PDF</span>
                        <a href="{{ Storage::url($material->file_attachment) }}" target="_blank" class="text-rose-600 hover:underline">Buka di Tab Baru &rarr;</a>
                    </div>
                    <iframe src="{{ Storage::url($material->file_attachment) }}" class="w-full h-[500px]" frameborder="0"></iframe>
                </div>
                @endif

                <!-- Video Embed if available -->
                @if($material->video_url)
                <div class="aspect-video w-full rounded-2xl overflow-hidden shadow-lg mb-8 bg-slate-900">
                    <iframe class="w-full h-full" src="{{ $material->video_url }}" title="{{ $material->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endif

                <!-- Textual Content / Exercises -->
                <div class="prose max-w-none text-slate-700 text-sm leading-relaxed whitespace-pre-line bg-slate-50/50 p-6 rounded-2xl border border-slate-100">
                    {{ $material->content ?? 'Tidak ada catatan teks tambahan untuk modul ini.' }}
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
