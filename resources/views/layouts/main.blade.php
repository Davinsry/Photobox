<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
<body class="antialiased bg-slate-955 text-slate-100 selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-slate-950/80 backdrop-blur-md border-b border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="font-outfit font-bold text-2xl tracking-tight text-white hover:opacity-95 transition-opacity">
                        Studio<span class="text-indigo-400">ku</span> <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2 py-0.5 rounded-full font-mono font-medium tracking-normal ml-1 border border-indigo-500/30">Jogja</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }} transition-colors">Home</a>
                    <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }} transition-colors">Layanan</a>
                    <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }} transition-colors">Galeri</a>
                    <a href="{{ route('testimoni') }}" class="{{ request()->routeIs('testimoni') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }} transition-colors">Testimoni</a>
                    <a href="{{ route('booking.cek.form') }}" class="{{ request()->routeIs('booking.cek.*') ? 'text-indigo-400 font-semibold' : 'text-slate-300 hover:text-white' }} transition-colors">Cek Booking</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.login') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Admin Area</a>
                    <a href="{{ route('booking.step1') }}" class="px-5 py-2.5 rounded-full bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-600 hover:to-cyan-600 text-white font-medium transition-all shadow-lg shadow-indigo-500/30 hover:scale-105">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20">
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
    <footer class="bg-slate-950 py-12 border-t border-slate-900 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center space-y-6 md:space-y-0">
            <div>
                <span class="font-outfit font-bold text-2xl tracking-tight text-white">
                    Studio<span class="text-indigo-400">ku</span>
                </span>
                <p class="text-slate-500 mt-2">Yogyakarta's Premium Photobox Experience.</p>
            </div>
            <div class="flex space-x-6 text-sm text-slate-500">
                <a href="{{ route('layanan') }}" class="hover:text-slate-300 transition-colors">Layanan</a>
                <a href="{{ route('galeri') }}" class="hover:text-slate-300 transition-colors">Galeri</a>
                <a href="{{ route('testimoni') }}" class="hover:text-slate-300 transition-colors">Testimoni</a>
                <a href="{{ route('admin.login') }}" class="hover:text-slate-300 transition-colors">Admin Login</a>
            </div>
            <div class="text-slate-600 text-sm">
                &copy; {{ date('Y') }} Studioku Jogja. All rights reserved.
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
