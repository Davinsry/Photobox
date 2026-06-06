<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | Studioku Jogja</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,655,700,800|outfit:400,500,655,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
    @yield('styles')
</head>
<body class="antialiased bg-slate-955 text-slate-100 min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-slate-950 border-r border-slate-900 flex flex-col shrink-0">
        <!-- Logo Header -->
        <div class="h-20 flex items-center px-6 border-b border-slate-900 justify-between">
            <span class="font-outfit font-bold text-xl text-white">
                Studio<span class="text-indigo-400">ku</span> <span class="text-xs bg-indigo-500/20 text-indigo-300 px-2.5 py-0.5 rounded-full font-mono font-medium ml-1">Admin</span>
            </span>
            <a href="/" target="_blank" class="text-slate-500 hover:text-white transition-colors text-xs flex items-center">
                Lihat Web
                <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
        </div>

        <!-- Nav Links -->
        <nav class="flex-grow p-6 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.booking.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.booking.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kelola Booking
            </a>

            <a href="{{ route('admin.layanan.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.layanan.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Paket Layanan
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.jadwal.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Kelola Jadwal & Blokir
            </a>

            <a href="{{ route('admin.galeri.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.galeri.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kelola Galeri
            </a>

            <a href="{{ route('admin.testimoni.index') }}" class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('admin.testimoni.*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/10' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Kelola Testimoni
            </a>
        </nav>

        <!-- Logout Section -->
        <div class="p-6 border-t border-slate-900">
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-9 h-9 rounded-full bg-slate-900 flex items-center justify-center font-bold text-indigo-400 border border-slate-800">
                    A
                </div>
                <div class="truncate">
                    <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name }}</span>
                    <span class="block text-xxs text-slate-500 truncate">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-rose-500/10 hover:text-rose-400 text-slate-400 text-xs font-bold transition-all border border-slate-850">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Topbar -->
        <header class="h-20 border-b border-slate-900 bg-slate-950/20 flex items-center justify-between px-8 z-10">
            <h1 class="text-xl font-bold font-outfit text-white">@yield('page_title', 'Dashboard')</h1>
            <div class="text-xs text-slate-400">
                Tanggal: <span class="font-bold text-slate-200">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
            </div>
        </header>

        <!-- Page Inner Content -->
        <main class="flex-grow p-8 overflow-y-auto">
            <!-- Toast Notifications -->
            @if(session('success'))
                <div class="mb-8 max-w-4xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-8 max-w-4xl bg-rose-500/10 border border-rose-500/20 text-rose-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
