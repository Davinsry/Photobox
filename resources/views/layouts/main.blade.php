<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden max-w-full w-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Studioku Jogja') | Premium Photobox</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
    @yield('styles')
</head>
<body class="antialiased bg-[#05070c] text-slate-100 selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col relative overflow-x-hidden max-w-full w-full">

    <!-- Ambient Glowing Spotlights -->
    <div class="absolute top-[-250px] left-[-200px] w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-[130px] pointer-events-none z-0"></div>
    <div class="absolute top-[25%] right-[-300px] w-[700px] h-[700px] rounded-full bg-purple-500/5 blur-[150px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[-100px] left-[-100px] w-[650px] h-[650px] rounded-full bg-cyan-500/8 blur-[120px] pointer-events-none z-0"></div>

    <!-- Floating Navbar -->
    <header class="fixed top-4 left-1/2 -translate-x-1/2 w-[92%] max-w-7xl z-50 bg-slate-950/60 backdrop-blur-xl border border-white/5 rounded-3xl shadow-2xl shadow-black/40">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-outfit font-extrabold text-2xl tracking-tight text-white hover:opacity-90 transition-all">
                        Studio<span class="text-indigo-400">ku</span> <span class="text-[10px] bg-indigo-500/10 text-indigo-300 px-2 py-0.5 rounded-full font-mono font-medium tracking-normal ml-1 border border-indigo-500/20">Jogja</span>
                    </a>
                </div>

                <!-- Nav links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-sm transition-colors {{ request()->routeIs('home') ? 'text-indigo-400 font-bold' : 'text-slate-300 hover:text-white' }}">Home</a>
                    <a href="{{ route('layanan') }}" class="text-sm transition-colors {{ request()->routeIs('layanan') ? 'text-indigo-400 font-bold' : 'text-slate-300 hover:text-white' }}">Layanan</a>
                    <a href="{{ route('galeri') }}" class="text-sm transition-colors {{ request()->routeIs('galeri') ? 'text-indigo-400 font-bold' : 'text-slate-300 hover:text-white' }}">Galeri</a>
                    <a href="{{ route('testimoni') }}" class="text-sm transition-colors {{ request()->routeIs('testimoni') ? 'text-indigo-400 font-bold' : 'text-slate-300 hover:text-white' }}">Testimoni</a>
                    <a href="{{ route('booking.cek.form') }}" class="text-sm transition-colors {{ request()->routeIs('booking.cek.*') ? 'text-indigo-400 font-bold' : 'text-slate-300 hover:text-white' }}">Cek Booking</a>
                </div>

                <!-- Quick actions -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.login') }}" class="hidden sm:inline-block text-xs font-semibold text-slate-400 hover:text-white transition-colors">Admin Area</a>
                    <a href="{{ route('booking.step1') }}" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white text-xs font-bold transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.03] active:scale-[0.98]">
                        Book Now
                    </a>
                    <!-- Hamburger Menu Button -->
                    <button id="mobile-menu-button" class="md:hidden p-2 text-slate-400 hover:text-white focus:outline-none transition-colors" aria-label="Toggle Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-white/5 px-6 py-4 space-y-2 flex flex-col rounded-b-3xl bg-slate-950/90 backdrop-blur-2xl">
            <a href="{{ route('home') }}" class="text-sm py-2 px-3 rounded-xl transition-colors {{ request()->routeIs('home') ? 'bg-indigo-500/10 text-indigo-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">Home</a>
            <a href="{{ route('layanan') }}" class="text-sm py-2 px-3 rounded-xl transition-colors {{ request()->routeIs('layanan') ? 'bg-indigo-500/10 text-indigo-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">Layanan</a>
            <a href="{{ route('galeri') }}" class="text-sm py-2 px-3 rounded-xl transition-colors {{ request()->routeIs('galeri') ? 'bg-indigo-500/10 text-indigo-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">Galeri</a>
            <a href="{{ route('testimoni') }}" class="text-sm py-2 px-3 rounded-xl transition-colors {{ request()->routeIs('testimoni') ? 'bg-indigo-500/10 text-indigo-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">Testimoni</a>
            <a href="{{ route('booking.cek.form') }}" class="text-sm py-2 px-3 rounded-xl transition-colors {{ request()->routeIs('booking.cek.*') ? 'bg-indigo-500/10 text-indigo-400 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">Cek Booking</a>
            <a href="{{ route('admin.login') }}" class="text-sm py-2 px-3 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 transition-colors border-t border-white/5 pt-3 mt-1 sm:hidden">Admin Area</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow pt-28 relative z-10">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#03050a] py-16 border-t border-white/[0.03] mt-auto relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            <div>
                <span class="font-outfit font-extrabold text-2xl tracking-tight text-white">
                    Studio<span class="text-indigo-400">ku</span>
                </span>
                <p class="text-slate-500 mt-2 text-sm">Yogyakarta's Premium Photobox Experience.</p>
            </div>
            <div class="flex space-x-8 text-xs text-slate-400">
                <a href="{{ route('layanan') }}" class="hover:text-slate-200 transition-colors">Layanan</a>
                <a href="{{ route('galeri') }}" class="hover:text-slate-200 transition-colors">Galeri</a>
                <a href="{{ route('testimoni') }}" class="hover:text-slate-200 transition-colors">Testimoni</a>
                <a href="{{ route('admin.login') }}" class="hover:text-slate-200 transition-colors">Admin Login</a>
            </div>
            <div class="text-slate-600 text-xs font-medium">
                &copy; {{ date('Y') }} Studioku Jogja. All rights reserved.
            </div>
        </div>
    </footer>

    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function() {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        menuIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                    } else {
                        mobileMenu.classList.add('hidden');
                        menuIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
