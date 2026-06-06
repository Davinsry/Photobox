<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studioku Jogja | Premium Photobox</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-outfit { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-slate-900 text-slate-100 selection:bg-indigo-500 selection:text-white">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-slate-900/80 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex-shrink-0 flex items-center">
                    <span class="font-outfit font-bold text-2xl tracking-tight text-white">
                        Studio<span class="text-indigo-400">ku</span>
                    </span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-slate-300 hover:text-white transition-colors">Home</a>
                    <a href="#packages" class="text-slate-300 hover:text-white transition-colors">Packages</a>
                    <a href="#gallery" class="text-slate-300 hover:text-white transition-colors">Gallery</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-400 hover:text-white transition-colors">Admin Login</a>
                    <a href="#packages" class="px-5 py-2.5 rounded-full bg-indigo-500 hover:bg-indigo-600 text-white font-medium transition-all shadow-lg shadow-indigo-500/30">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-indigo-900/20 to-slate-900 z-10"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] opacity-30 bg-indigo-500 blur-[120px] rounded-full mix-blend-screen pointer-events-none"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-medium mb-8">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                <span>Yogyakarta's Premier Photobox</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8">
                Capture Your <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Best Moments</span>
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-xl text-slate-400 mb-10">
                Professional photobox and studio sessions with instant digital delivery. 
                No account needed—just book, smile, and get your photos.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="#packages" class="px-8 py-4 w-full sm:w-auto rounded-full bg-white text-slate-900 font-bold text-lg hover:bg-slate-100 transition-all shadow-[0_0_40px_rgba(255,255,255,0.3)]">
                    View Packages
                </a>
                <a href="#" class="px-8 py-4 w-full sm:w-auto rounded-full bg-slate-800 text-white font-bold text-lg hover:bg-slate-700 transition-all border border-slate-700">
                    Check Booking Status
                </a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-24 bg-slate-800/50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">Choose Your Session</h2>
                <p class="text-lg text-slate-400">Select the package that fits your needs. All packages include softfiles and professional lighting.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                <div class="bg-slate-900 rounded-3xl p-8 border border-slate-700 hover:border-indigo-500 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm3 3h6v6H9V9z"/></svg>
                    </div>
                    
                    <h3 class="text-2xl font-bold mb-2">{{ $package->name }}</h3>
                    <p class="text-slate-400 mb-6 flex-grow">{{ $package->description }}</p>
                    
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-extrabold">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $package->duration_minutes }} Minutes Session
                        </li>
                    </ul>
                    
                    <a href="{{ route('booking.create', $package->id) }}" class="block w-full py-4 px-6 rounded-2xl bg-indigo-500/10 text-indigo-400 font-bold text-center group-hover:bg-indigo-500 group-hover:text-white transition-all mt-auto border border-indigo-500/20 group-hover:border-indigo-500">
                        Select Package
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">No packages currently available.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <span class="font-outfit font-bold text-2xl tracking-tight text-white">
                    Studio<span class="text-indigo-400">ku</span>
                </span>
                <p class="text-slate-500 mt-2">Yogyakarta's Premium Photobox Experience.</p>
            </div>
            <div class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} Studioku Jogja. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
