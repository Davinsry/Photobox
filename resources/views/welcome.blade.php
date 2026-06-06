@extends('layouts.main')

@section('title', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative pt-12 pb-20 lg:pt-28 lg:pb-36 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-indigo-950/20 via-slate-955 to-slate-955 z-10"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[500px] opacity-20 bg-indigo-500 blur-[130px] rounded-full mix-blend-screen pointer-events-none"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-medium mb-8">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                <span>Yogyakarta's Premium Photobox Experience</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-8 leading-tight">
                Capture Your <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400">Best Moments</span>
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-slate-400 mb-10 leading-relaxed">
                Reservasi sesi foto instan di Yogyakarta secara online tanpa ribet. 
                Tanpa perlu daftar akun, cukup pilih paket, jadwalkan, dan bayar lewat QRIS/Virtual Account.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('booking.step1') }}" class="px-8 py-4 w-full sm:w-auto rounded-full bg-white text-slate-950 font-bold text-lg hover:bg-slate-100 transition-all hover:scale-105 shadow-[0_0_30px_rgba(255,255,255,0.15)] text-center">
                    Mulai Booking
                </a>
                <a href="{{ route('booking.cek.form') }}" class="px-8 py-4 w-full sm:w-auto rounded-full bg-slate-900 text-slate-300 font-bold text-lg hover:bg-slate-800 transition-all border border-slate-800 text-center hover:scale-105">
                    Cek Status Booking
                </a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-24 bg-slate-900/40 border-t border-slate-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">Pilihan Paket Layanan</h2>
                <p class="text-lg text-slate-400">Pilih paket terbaik yang sesuai dengan kebutuhan Anda. Semua paket sudah termasuk softfile dan lighting profesional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                <div class="bg-slate-900/60 rounded-3xl p-8 border border-slate-800 hover:border-indigo-500/50 transition-all duration-300 group relative overflow-hidden flex flex-col h-full hover:shadow-2xl hover:shadow-indigo-500/5">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                        <svg class="w-24 h-24 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4h16v16H4V4zm2 2v12h12V6H6zm3 3h6v6H9V9z"/></svg>
                    </div>

                    @if($package->thumbnail)
                        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover rounded-2xl mb-6 border border-slate-800">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-900/40 to-slate-800 rounded-2xl mb-6 flex items-center justify-center border border-slate-800">
                            <svg class="w-12 h-12 text-indigo-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-2xl font-bold mb-2 text-white">{{ $package->name }}</h3>
                    <p class="text-slate-400 mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>
                    
                    <div class="flex items-baseline mb-8">
                        <span class="text-3xl font-extrabold text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>

                    <ul class="space-y-4 mb-8 text-sm">
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Durasi Sesi: {{ $package->duration_minutes }} Menit
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Instant Digital Delivery (Softfile)
                        </li>
                    </ul>
                    
                    <a href="{{ route('booking.step2', ['package_id' => $package->id]) }}" class="block w-full py-4 px-6 rounded-2xl bg-indigo-500/10 text-indigo-400 font-bold text-center group-hover:bg-indigo-500 group-hover:text-white transition-all mt-auto border border-indigo-500/20 group-hover:border-indigo-500">
                        Pilih Paket
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada paket layanan aktif.</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('layanan') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-semibold group">
                    Lihat Semua Paket 
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-24 border-t border-slate-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">Galeri Studio</h2>
                <p class="text-lg text-slate-400">Kumpulan potret seru dan estetis dari customer yang sudah berkunjung ke Studioku Jogja.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleries as $gallery)
                <div class="group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all duration-300">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Gallery Image' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @if($gallery->caption)
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-955/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <p class="text-sm text-slate-200 font-medium leading-relaxed">{{ $gallery->caption }}</p>
                        </div>
                    @endif
                </div>
                @empty
                <div class="group relative rounded-3xl overflow-hidden aspect-[4/3] bg-gradient-to-br from-indigo-950/20 to-slate-900 border border-slate-800 flex items-center justify-center p-6 text-center text-slate-500 text-sm">
                    Galeri foto kosong. Unggah via admin panel.
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('galeri') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-semibold group">
                    Jelajahi Galeri 
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-slate-900/20 border-t border-slate-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold mb-4">Testimoni Pelanggan</h2>
                <p class="text-lg text-slate-400">Apa kata mereka yang telah merayakan momen seru di Studioku Jogja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/20 hover:bg-slate-900/80 transition-all">
                    <!-- Stars -->
                    <div class="flex items-center space-x-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    
                    <p class="text-slate-300 leading-relaxed mb-6 italic">"{{ $testimonial->content }}"</p>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center font-bold text-indigo-400">
                            {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-white">{{ $testimonial->customer_name }}</h4>
                            <p class="text-xs text-slate-500">Verified Customer</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada testimoni.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('testimoni') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-semibold group">
                    Semua Ulasan 
                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
