@extends('layouts.main')

@section('title', 'Pilih Paket - Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Steps Progress Bar -->
    <div class="mb-16 max-w-3xl mx-auto bg-slate-950/40 backdrop-blur-md p-6 rounded-3xl border border-white/[0.05] shadow-lg shadow-black/20">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-9 h-9 rounded-2xl bg-indigo-500 text-white flex items-center justify-center mb-2 font-black shadow-lg shadow-indigo-500/20 ring-2 ring-indigo-500/20">1</span>
                <span class="font-bold">Pilih Paket</span>
            </div>
            <div class="h-[2px] bg-white/[0.05] flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">2</span>
                <span>Jadwal & Waktu</span>
            </div>
            <div class="h-[2px] bg-white/[0.05] flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">3</span>
                <span>Data Diri</span>
            </div>
            <div class="h-[2px] bg-white/[0.05] flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">4</span>
                <span>Konfirmasi</span>
            </div>
        </div>
    </div>

    <div class="text-center max-w-xl mx-auto mb-12">
        <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Langkah 01</span>
        <h2 class="text-3xl md:text-4xl font-extrabold font-outfit text-white mt-1">Pilih Paket Layanan</h2>
        <div class="w-12 h-1 bg-indigo-500 mx-auto rounded-full mt-3"></div>
        <p class="text-slate-400 mt-3 text-sm">Pilih paket photobox terbaik yang ingin Anda pesan untuk sesi foto Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
        @forelse($packages as $package)
        @php
            $isPopular = Str::contains(strtolower($package->name), 'premium');
        @endphp
        <div class="bg-slate-955/40 backdrop-blur-md border {{ $isPopular ? 'border-indigo-500/40 ring-1 ring-indigo-500/20' : 'border-white/[0.05]' }} rounded-3xl p-8 flex flex-col hover:border-indigo-500/40 transition-all duration-300 relative group hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-1">
            @if($isPopular)
                <div class="absolute top-4 right-4 bg-indigo-500 text-white text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-full shadow-lg shadow-indigo-500/20">
                    Terpopuler
                </div>
            @endif

            @if($package->thumbnail)
                <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover rounded-2xl mb-6 border border-white/[0.05]">
            @endif

            <h3 class="text-2xl font-extrabold font-outfit text-white mb-2">{{ $package->name }}</h3>
            <p class="text-slate-400 text-sm mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>

            <div class="flex items-baseline mb-6">
                <span class="text-3xl font-black text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>

            <div class="border-t border-white/[0.05] pt-6 mb-8 text-sm text-slate-300 space-y-3">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-indigo-400 mr-3 bg-indigo-500/10 p-1 rounded-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Durasi Sesi: <strong class="text-white">{{ $package->duration_minutes }} Menit</strong></span>
                </div>
            </div>

            <form action="{{ route('booking.step1') }}" method="GET" class="mt-auto">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <button type="submit" class="w-full py-4 rounded-2xl {{ $isPopular ? 'bg-indigo-500 hover:bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }} font-bold text-sm text-center transition-all group-hover:scale-[1.01] border border-white/5">
                    Pilih Paket ini
                </button>
            </form>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-slate-950/40 backdrop-blur-md rounded-3xl border border-white/[0.05]">
            <p class="text-slate-400 text-lg">Maaf, saat ini belum ada paket aktif yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
