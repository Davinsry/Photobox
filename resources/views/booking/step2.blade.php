@extends('layouts.main')

@section('title', 'Pilih Jadwal - Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Steps Progress Bar -->
    <div class="mb-16 max-w-3xl mx-auto bg-slate-950/40 backdrop-blur-md p-6 rounded-3xl border border-white/[0.05] shadow-lg shadow-black/20">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center text-slate-400">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">1</span>
                <span>Pilih Paket</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-9 h-9 rounded-2xl bg-indigo-500 text-white flex items-center justify-center mb-2 font-black shadow-lg shadow-indigo-500/20 ring-2 ring-indigo-500/20">2</span>
                <span class="font-bold">Jadwal & Waktu</span>
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

    <div class="max-w-4xl mx-auto">
        <!-- Main Form Container -->
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 shadow-2xl shadow-black/30">
            <!-- Selected Package Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-white/[0.05] pb-6 mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-400 font-mono">Paket Pilihan</span>
                    <h2 class="text-2xl font-extrabold font-outfit text-white mt-1">{{ $package->name }}</h2>
                    <p class="text-xs text-slate-400 mt-1.5 flex items-center">
                        <svg class="w-4 h-4 text-indigo-400 mr-1.5 bg-indigo-500/10 p-0.5 rounded" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Sesi: {{ $package->duration_minutes }} Menit 
                        <span class="mx-2 text-white/10">|</span> 
                        <strong class="text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</strong>
                    </p>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('booking.step1') }}" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 flex items-center bg-indigo-500/5 px-4 py-2 border border-indigo-500/20 rounded-xl transition-all hover:scale-[1.02]">
                        <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Ganti Paket
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-8 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('booking.step2') }}" method="POST" id="booking-form">
                @csrf
                
                <!-- Date Picker -->
                <div class="mb-8 max-w-sm">
                    <label for="date" class="block text-sm font-semibold text-slate-300 mb-2">Pilih Tanggal Sesi</label>
                    <div class="relative">
                        <input type="date" name="date" id="date" 
                               min="{{ \Carbon\Carbon::today()->toDateString() }}" 
                               value="{{ $selectedDate }}"
                               onchange="window.location.href = '{{ route('booking.step2') }}?date=' + this.value"
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer appearance-none">
                    </div>
                </div>

                <!-- Time Slot Grid -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-slate-300">Pilih Slot Waktu Yang Tersedia</label>
                        <span class="text-xs text-slate-500 font-medium">Zona waktu Asia/Jakarta (WIB)</span>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @forelse($slots as $slot)
                            @if($slot['is_available'])
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="slot" value="{{ $slot['start'] }}-{{ $slot['end'] }}" class="peer sr-only" required>
                                    <div class="bg-slate-900/60 border border-white/[0.05] hover:border-indigo-500/50 rounded-2xl p-4 text-center transition-all peer-checked:bg-gradient-to-r peer-checked:from-indigo-500 peer-checked:to-purple-600 peer-checked:border-indigo-500 peer-checked:text-white group-hover:scale-[1.02]">
                                        <span class="block font-black text-lg text-white">{{ $slot['start'] }}</span>
                                        <span class="block text-xs text-slate-400 mt-1 peer-checked:text-indigo-100">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                                    </div>
                                    <span class="absolute top-2 right-2 w-1.5 h-1.5 rounded-full bg-emerald-500 group-hover:animate-ping"></span>
                                </label>
                            @else
                                <div class="bg-slate-950/20 border border-white/[0.02] rounded-2xl p-4 text-center opacity-40 cursor-not-allowed select-none relative">
                                    <span class="block font-bold text-lg text-slate-500">{{ $slot['start'] }}</span>
                                    <span class="block text-[9px] text-rose-500 font-bold uppercase tracking-tight mt-1.5 truncate">{{ $slot['reason'] ?: 'Tidak Tersedia' }}</span>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-10 bg-slate-900/20 border border-white/[0.05] rounded-2xl">
                                <p class="text-slate-400 text-sm">Tidak ada slot waktu tersedia pada tanggal ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-white/[0.05]">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-sm rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-[0.98]">
                        Lanjut Isi Data Diri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
