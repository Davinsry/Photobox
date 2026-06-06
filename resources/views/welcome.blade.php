@extends('layouts.main')

@section('title', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative pt-12 pb-20 lg:pt-20 lg:pb-32 overflow-hidden flex items-center min-h-[80vh]">
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-b from-[#05070c]/50 via-[#05070c] to-[#05070c] z-10"></div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center space-x-2.5 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/25 text-indigo-300 text-xs font-semibold tracking-wide uppercase mb-8 backdrop-blur-md animate-pulse">
                <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                <span>Yogyakarta's Premium Photobox Experience</span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black tracking-tight mb-8 leading-none font-outfit text-white">
                Capture Your <br class="hidden md:block"/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 drop-shadow-sm">Best Moments</span>
            </h1>
            
            <p class="mt-4 max-w-2xl mx-auto text-base md:text-lg text-slate-400 mb-12 leading-relaxed">
                Reservasi sesi foto instan di Yogyakarta secara online tanpa ribet. 
                Tanpa perlu daftar akun, cukup pilih paket, jadwalkan, dan bayar lewat QRIS/Virtual Account.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center items-center gap-5 max-w-md mx-auto">
                <a href="{{ route('booking.step1') }}" class="px-8 py-4 w-full sm:w-auto rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-sm transition-all hover:scale-[1.03] active:scale-[0.98] shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 text-center">
                    Mulai Booking
                </a>
                <a href="{{ route('booking.cek.form') }}" class="px-8 py-4 w-full sm:w-auto rounded-2xl bg-slate-900/60 text-slate-200 font-bold text-sm hover:bg-slate-800/80 transition-all border border-white/5 text-center hover:scale-[1.03] active:scale-[0.98] backdrop-blur-md">
                    Cek Status Booking
                </a>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Paket Studio</span>
                <h2 class="text-3xl md:text-5xl font-extrabold font-outfit mt-2 mb-4 text-white">Pilihan Paket Layanan</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-6"></div>
                <p class="text-base text-slate-400 leading-relaxed">Pilih paket terbaik yang sesuai dengan kebutuhan Anda. Semua paket sudah termasuk softfile dan pencahayaan studio profesional.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                @php
                    $isPopular = Str::contains(strtolower($package->name), 'premium');
                @endphp
                <div class="bg-slate-950/40 backdrop-blur-md rounded-3xl p-8 border {{ $isPopular ? 'border-indigo-500/40 ring-1 ring-indigo-500/20' : 'border-white/[0.05]' }} hover:border-indigo-500/40 transition-all duration-500 group relative overflow-hidden flex flex-col h-full hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1">
                    @if($isPopular)
                        <div class="absolute top-4 right-4 bg-indigo-500 text-white text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full shadow-lg shadow-indigo-500/20">
                            Terpopuler
                        </div>
                    @endif

                    @if($package->thumbnail)
                        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-52 object-cover rounded-2xl mb-6 border border-white/[0.05] group-hover:scale-[1.01] transition-transform duration-500">
                    @else
                        <div class="w-full h-52 bg-gradient-to-br from-indigo-950/50 to-slate-900/50 rounded-2xl mb-6 flex items-center justify-center border border-white/[0.05]">
                            <svg class="w-12 h-12 text-indigo-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-2xl font-extrabold font-outfit mb-2 text-white">{{ $package->name }}</h3>
                    <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>
                    
                    <div class="flex items-baseline mb-8">
                        <span class="text-3xl font-black text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>

                    <ul class="space-y-4 mb-8 text-sm border-t border-white/[0.05] pt-6">
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Durasi Sesi: <strong class="text-white">{{ $package->duration_minutes }} Menit</strong></span>
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Semua softfile dikirim instant</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('booking.step1', ['package_id' => $package->id]) }}" class="block w-full py-4 px-6 rounded-2xl {{ $isPopular ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-600' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }} font-bold text-sm text-center transition-all mt-auto border border-white/5">
                        Pilih Paket
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada paket layanan aktif.</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-14">
                <a href="{{ route('layanan') }}" class="inline-flex items-center text-sm text-indigo-400 hover:text-indigo-300 font-bold tracking-wide uppercase group transition-colors">
                    Lihat Semua Paket 
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Hasil Foto</span>
                <h2 class="text-3xl md:text-5xl font-extrabold font-outfit mt-2 mb-4 text-white">Galeri Studio</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-6"></div>
                <p class="text-base text-slate-400 leading-relaxed">Kumpulan potret seru dan estetis dari customer yang sudah berkunjung ke Studioku Jogja.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($galleries as $gallery)
                <div class="group relative rounded-3xl overflow-hidden aspect-[4/3] bg-slate-950/40 border border-white/[0.05] hover:border-indigo-500/30 transition-all duration-500 hover:shadow-2xl hover:shadow-indigo-500/5">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Gallery Image' }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#05070c] via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>
                    @if($gallery->caption)
                        <div class="absolute inset-0 flex items-end p-6 translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="text-sm text-slate-200 font-semibold leading-relaxed drop-shadow-md bg-slate-950/40 backdrop-blur-sm px-4 py-2 rounded-xl border border-white/5 w-full">{{ $gallery->caption }}</p>
                        </div>
                    @endif
                </div>
                @empty
                <div class="col-span-full py-16 bg-slate-955/40 rounded-3xl border border-white/[0.05] flex items-center justify-center p-6 text-center text-slate-500 text-sm">
                    Galeri foto kosong. Unggah via admin panel.
                </div>
                @endforelse
            </div>

            <div class="text-center mt-14">
                <a href="{{ route('galeri') }}" class="inline-flex items-center text-sm text-indigo-400 hover:text-indigo-300 font-bold tracking-wide uppercase group transition-colors">
                    Jelajahi Galeri 
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Ulasan Jujur</span>
                <h2 class="text-3xl md:text-5xl font-extrabold font-outfit mt-2 mb-4 text-white">Testimoni Pelanggan</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-6"></div>
                <p class="text-base text-slate-400 leading-relaxed">Apa kata mereka yang telah merayakan momen seru di Studioku Jogja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 hover:border-indigo-500/20 hover:bg-slate-950/80 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/5 flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center space-x-1 mb-6">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4.5 h-4.5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        
                        <p class="text-slate-300 text-sm leading-relaxed mb-6 italic">"{{ $testimonial->content }}"</p>
                    </div>
                    
                    <div class="flex items-center space-x-3.5 pt-4 border-t border-white/[0.05]">
                        <div class="w-9 h-9 rounded-xl bg-indigo-500/10 flex items-center justify-center font-extrabold text-sm text-indigo-400 border border-indigo-500/20 uppercase">
                            {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-white">{{ $testimonial->customer_name }}</h4>
                            <p class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">Verified Customer</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada testimoni.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-14">
                <a href="{{ route('testimoni') }}" class="inline-flex items-center text-sm text-indigo-400 hover:text-indigo-300 font-bold tracking-wide uppercase group transition-colors">
                    Semua Ulasan 
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
