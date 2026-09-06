<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bloom English with Love')</title>
    
    <!-- Favicon using Bloom English Logo -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}">

    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        bloom: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            500: '#f43f5e',
                            600: '#e11d48',
                            700: '#be123c',
                            900: '#881337',
                        },
                        indigoBrand: {
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-brand {
            background: linear-gradient(135deg, #be123c 0%, #4f46e5 100%);
        }
        .gradient-card {
            background: linear-gradient(135deg, #ffffff 0%, #fff1f2 100%);
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans text-slate-800 antialiased selection:bg-rose-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <nav class="sticky top-0 z-50 glass-header border-b border-rose-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                <!-- Brand Logo & Name -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="flex items-center space-x-3 group">
                        <!-- Clean Natural Logo (No Circular Frame / Bingkai) -->
                        <img src="{{ asset('images/logo.jpg') }}" alt="Bloom English Logo" class="h-12 sm:h-14 w-auto object-contain mix-blend-multiply group-hover:scale-105 transition-transform duration-200">
                        <div>
                            <span class="text-xl font-extrabold tracking-tight text-slate-900 flex items-center gap-1.5">
                                Bloom English <span class="text-rose-600">with Love</span>
                                <span class="inline-block text-xs text-rose-500 animate-pulse">❤️</span>
                            </span>
                            <span class="block text-xs font-medium text-slate-500">Interactive English Platform</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links based on Auth & Role -->
                @auth
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                            Dashboard Admin
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                            👥 Kelola User
                        </a>
                    @elseif(Auth::user()->isInstructor())
                        <a href="{{ route('instructor.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('instructor.dashboard') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                            Dashboard Instructor
                        </a>
                    @elseif(Auth::user()->isStudent())
                        <a href="{{ route('student.dashboard') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('student.dashboard') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                            Dashboard Saya
                        </a>
                    @endif

                    <a href="{{ route('courses.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('courses.*') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                        📚 Katalog Course
                    </a>

                    <a href="{{ route('webinars.index') }}" class="px-3.5 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('webinars.*') ? 'bg-rose-50 text-rose-600 shadow-xs' : 'text-slate-600 hover:text-rose-600 hover:bg-slate-50' }}">
                        🌐 Jadwal Webinar
                    </a>
                </div>

                <!-- User Profile & Role Badge -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 pl-3 border-l border-slate-200">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</div>
                            @if(Auth::user()->isAdmin())
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-purple-100 text-purple-700">
                                    👑 Admin
                                </span>
                            @elseif(Auth::user()->isInstructor())
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-indigo-100 text-indigo-700">
                                    🎓 Instructor
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700">
                                    ⭐ Student
                                </span>
                            @endif
                        </div>

                        <!-- Logout Button -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Keluar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white gradient-brand shadow-md hover:shadow-lg hover:opacity-95 transition-all">
                        Daftar Gratis
                    </a>
                </div>
                @endauth

            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="flex-grow">
        <!-- Toast Flash Notifications -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if (session('success'))
                <div class="p-4 mb-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-xs animate-fade-in">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl">✨</span>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 mb-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-xs">
                    <div class="flex items-center space-x-3">
                        <span class="text-xl">⚠️</span>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200/80 mt-16 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Bloom English" class="h-9 w-auto object-contain mix-blend-multiply">
                <span class="text-sm font-bold text-slate-700">Bloom English with Love &copy; {{ date('Y') }}</span>
            </div>
            <p class="text-xs text-slate-500 text-center">
                Platform Pembelajaran Bahasa Inggris Terintegrasi untuk Student, Instructor & Admin.
            </p>
        </div>
    </footer>

</body>
</html>
