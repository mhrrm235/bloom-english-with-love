@extends('layouts.app')

@section('title', 'Daftar Student - Bloom English with Love')

@section('content')
<div class="min-h-[85vh] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Expanded Register Card Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-10 px-6 sm:px-12 shadow-2xl shadow-rose-200/50 border border-slate-100 rounded-3xl sm:rounded-[2.5rem] relative overflow-hidden">
            
            <!-- Top & Bottom Glow Effects -->
            <div class="absolute -top-12 -left-12 w-40 h-40 bg-rose-200/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 bg-indigo-200/40 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Card Header: Blend Logo Seamlessly with Card Background -->
            <div class="text-center mb-8 relative z-10">
                <img src="{{ asset('images/logo.jpg') }}" alt="Bloom English Logo" class="h-36 sm:h-44 w-auto max-w-full mx-auto object-contain mb-4 mix-blend-multiply">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Registrasi Student Baru
                </h2>
                <p class="mt-2 text-sm sm:text-base font-semibold text-rose-600">
                    Bloom English with Love <span class="text-slate-400 font-normal">| Bergabung & Belajar</span>
                </p>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5 relative z-10">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            👤
                        </div>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                            placeholder="Contoh: Budi Santoso"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium transition-all">
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Alamat Email</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            📧
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium transition-all">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Kata Sandi (Minimal 8 Karakter)</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            🔒
                        </div>
                        <input id="password" name="password" type="password" required
                            placeholder="••••••••"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium transition-all">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-1">Konfirmasi Kata Sandi</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            🔑
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            placeholder="••••••••"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium transition-all">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-lg shadow-rose-500/20 text-base font-extrabold text-white gradient-brand hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all transform hover:-translate-y-0.5">
                        Daftar Akun Student Sekarang &rarr;
                    </button>
                </div>
            </form>

            <!-- Footer Login Link Inside Card -->
            <div class="mt-8 text-center relative z-10">
                <p class="text-sm font-medium text-slate-600">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-extrabold text-rose-600 hover:text-rose-700 underline decoration-rose-300 decoration-2 underline-offset-4">Masuk di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
