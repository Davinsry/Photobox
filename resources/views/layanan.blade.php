@extends('layouts.main')

@section('title', 'Layanan')

@section('content')
    <section class="py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Katalog Layanan</span>
                <h1 class="text-4xl md:text-6xl font-extrabold font-outfit mt-2 mb-4 text-white">Paket Layanan Kami</h1>
                <div class="w-16 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 mx-auto rounded-full mb-6"></div>
                <p class="text-base text-slate-400 leading-relaxed">Temukan sesi foto studio dan photobox premium dengan pencahayaan terbaik di Jogja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                @php
                    $isPopular = Str::contains(strtolower($package->name), 'premium');
                @endphp
                <div class="bg-slate-950/40 backdrop-blur-md rounded-3xl p-8 border {{ $isPopular ? 'border-indigo-500/40 ring-1 ring-indigo-500/20' : 'border-white/[0.05]' }} hover:border-indigo-500/40 transition-all duration-500 group flex flex-col h-full hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1 relative">
                    @if($isPopular)
                        <div class="absolute top-4 right-4 bg-indigo-500 text-white text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full shadow-lg shadow-indigo-500/20">
                            Terpopuler
                        </div>
                    @endif

                    @if($package->thumbnail)
                        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-56 object-cover rounded-2xl mb-6 border border-white/[0.05] group-hover:scale-[1.01] transition-transform duration-500">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-indigo-950/50 to-slate-900/50 rounded-2xl mb-6 flex items-center justify-center border border-white/[0.05]">
                            <svg class="w-16 h-16 text-indigo-400/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-2xl font-extrabold font-outfit mb-2 text-white">{{ $package->name }}</h3>
                    <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>
                    
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-black text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>

                    <ul class="space-y-4 mb-8 text-sm border-t border-white/[0.05] pt-6">
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Durasi Sesi: <strong class="text-white">{{ $package->duration_minutes }} Menit</strong></span>
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Instant Digital Delivery (Semua softfile didapatkan)</span>
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Studio Backgrounds Pilihan</span>
                        </li>
                    </ul>
                    
                    <a href="{{ route('booking.step1', ['package_id' => $package->id]) }}" class="block w-full py-4 px-6 rounded-2xl {{ $isPopular ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/20 hover:bg-indigo-600' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }} font-bold text-sm text-center transition-all mt-auto border border-white/5">
                        Pilih & Lanjut Jadwal
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada paket layanan aktif.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
