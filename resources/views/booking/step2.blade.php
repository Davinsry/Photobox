@extends('layouts.main')

@section('title', 'Pilih Jadwal - Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Steps Progress Bar -->
    <div class="mb-12 max-w-3xl mx-auto">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">1</span>
                <span>Pilih Paket</span>
            </div>
            <div class="h-0.5 bg-indigo-500/50 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center mb-2 font-bold ring-4 ring-indigo-500/20">2</span>
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

    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-850 pb-6 mb-8">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400 font-mono">Paket Pilihan</span>
                    <h2 class="text-2xl font-bold font-outfit text-white">{{ $package->name }}</h2>
                    <p class="text-sm text-slate-400 mt-1">Sesi: {{ $package->duration_minutes }} Menit | Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('booking.step1') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Ganti Paket
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-8 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-6 py-4 rounded-2xl text-sm">
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
                               class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer appearance-none">
                    </div>
                </div>

                <!-- Time Slot Grid -->
                <div class="mb-10">
                    <label class="block text-sm font-semibold text-slate-300 mb-4">Pilih Slot Waktu Yang Tersedia</label>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @forelse($slots as $slot)
                            @if($slot['is_available'])
                                <label class="relative block cursor-pointer group">
                                    <input type="radio" name="slot" value="{{ $slot['start'] }}-{{ $slot['end'] }}" class="peer sr-only" required>
                                    <div class="bg-slate-950 border border-slate-850 hover:border-indigo-500/50 rounded-2xl p-4 text-center transition-all peer-checked:bg-indigo-500 peer-checked:border-indigo-500 peer-checked:text-white group-hover:scale-[1.02]">
                                        <span class="block font-bold text-lg text-white peer-checked:text-white">{{ $slot['start'] }}</span>
                                        <span class="block text-xs text-slate-400 mt-1 peer-checked:text-indigo-100">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                                    </div>
                                </label>
                            @else
                                <div class="bg-slate-950/40 border border-slate-900 rounded-2xl p-4 text-center opacity-40 cursor-not-allowed select-none relative">
                                    <span class="block font-bold text-lg text-slate-500">{{ $slot['start'] }}</span>
                                    <span class="block text-xxs text-rose-500 font-medium tracking-tight mt-1 truncate">{{ $slot['reason'] ?: 'Tidak Tersedia' }}</span>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-8 bg-slate-950/20 border border-slate-900 rounded-2xl">
                                <p class="text-slate-400 text-sm">Tidak ada slot waktu tersedia pada tanggal ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-850">
                    <button type="submit" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02]">
                        Lanjut Isi Data Diri
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
