@extends('layouts.main')

@section('title', 'Pilih Paket - Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Steps Progress Bar -->
    <div class="mb-12 max-w-3xl mx-auto">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center mb-2 font-bold ring-4 ring-indigo-500/20">1</span>
                <span>Pilih Paket</span>
            </div>
            <div class="h-0.5 bg-slate-800 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">2</span>
                <span>Jadwal & Waktu</span>
            </div>
            <div class="h-0.5 bg-slate-800 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">3</span>
                <span>Data Diri</span>
            </div>
            <div class="h-0.5 bg-slate-800 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">4</span>
                <span>Konfirmasi</span>
            </div>
        </div>
    </div>

    <div class="text-center max-w-xl mx-auto mb-10">
        <h2 class="text-3xl font-bold font-outfit text-white">Langkah 1: Pilih Paket Layanan</h2>
        <p class="text-slate-400 mt-2">Pilih paket photobox terbaik yang ingin Anda pesan.</p>
    </div>

    @if(session('error'))
        <div class="max-w-3xl mx-auto mb-8 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-6 py-4 rounded-2xl text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
        @forelse($packages as $package)
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 flex flex-col hover:border-indigo-500/50 transition-all duration-300 relative group">
            @if($package->thumbnail)
                <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-48 object-cover rounded-2xl mb-6">
            @endif

            <h3 class="text-2xl font-bold font-outfit text-white mb-2">{{ $package->name }}</h3>
            <p class="text-slate-400 mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>

            <div class="flex items-baseline mb-6">
                <span class="text-3xl font-extrabold text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>

            <div class="border-t border-slate-800 pt-6 mb-8 text-sm text-slate-300 space-y-3">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Durasi Sesi: {{ $package->duration_minutes }} Menit
                </div>
            </div>

            <form action="{{ route('booking.step1') }}" method="GET">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <button type="submit" class="w-full py-4 rounded-2xl bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-center transition-all shadow-lg shadow-indigo-500/20 group-hover:scale-[1.02]">
                    Pilih Paket ini
                </button>
            </form>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-slate-900 rounded-3xl border border-slate-800">
            <p class="text-slate-400 text-lg">Maaf, saat ini belum ada paket aktif yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
