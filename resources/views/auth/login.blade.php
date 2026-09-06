@extends('layouts.app')

@section('title', 'Masuk - Bloom English with Love')

@section('content')
<div class="min-h-[85vh] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <!-- Expanded Login Card Container -->
    <div class="sm:mx-auto sm:w-full sm:max-w-xl">
        <div class="bg-white py-10 px-6 sm:px-12 shadow-2xl shadow-rose-200/50 border border-slate-100 rounded-3xl sm:rounded-[2.5rem] relative overflow-hidden">
            
            <!-- Top Subtle Gradient Glow -->
            <div class="absolute -top-12 -left-12 w-40 h-40 bg-rose-200/40 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-40 h-40 bg-indigo-200/40 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Card Header: Blend Logo Seamlessly with Card Background -->
            <div class="text-center mb-8 relative z-10">
                <img src="{{ asset('images/logo.jpg') }}" alt="Bloom English Logo" class="h-36 sm:h-44 w-auto max-w-full mx-auto object-contain mb-4 mix-blend-multiply">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Masuk ke Akun Anda
                </h2>
                <p class="mt-2 text-sm sm:text-base font-semibold text-rose-600">
                    Bloom English with Love <span class="text-slate-400 font-normal">| Platform Interaktif</span>
                </p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6 relative z-10">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-slate-700 mb-1">Alamat Email</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            📧
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            value="{{ old('email', 'student@bloom.com') }}"
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
                    <label for="password" class="block text-sm font-bold text-slate-700 mb-1">Kata Sandi</label>
                    <div class="relative rounded-2xl shadow-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            🔒
                        </div>
                        <input id="password" name="password" type="password" required value="password123"
                            placeholder="••••••••"
                            class="block w-full pl-11 pr-4 py-3.5 border border-slate-300 rounded-2xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm font-medium transition-all">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-slate-300 rounded cursor-pointer">
                        <label for="remember" class="ml-2.5 block text-sm text-slate-700 font-semibold cursor-pointer">Ingat Saya di Perangkat Ini</label>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-lg shadow-rose-500/20 text-base font-extrabold text-white gradient-brand hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all transform hover:-translate-y-0.5">
                        Masuk Sekarang &rarr;
                    </button>
                </div>
            </form>



            <!-- Footer Register Link Inside Card -->
            <div class="mt-8 text-center relative z-10">
                <p class="text-sm font-medium text-slate-600">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="font-extrabold text-rose-600 hover:text-rose-700 underline decoration-rose-300 decoration-2 underline-offset-4">Daftar Student Baru</a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
