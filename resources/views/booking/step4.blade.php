@extends('layouts.main')

@section('title', 'Konfirmasi Booking')

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
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">2</span>
                <span>Jadwal & Waktu</span>
            </div>
            <div class="h-0.5 bg-indigo-500/50 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center">
                <span class="w-8 h-8 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mb-2 font-bold">3</span>
                <span>Data Diri</span>
            </div>
            <div class="h-0.5 bg-indigo-500/50 flex-grow -mt-6 mx-4"></div>
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-8 h-8 rounded-full bg-indigo-500 text-white flex items-center justify-center mb-2 font-bold ring-4 ring-indigo-500/20">4</span>
                <span>Konfirmasi</span>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
            <div class="border-b border-slate-850 pb-6 mb-8">
                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-400 font-mono">Langkah Terakhir</span>
                <h2 class="text-3xl font-bold font-outfit text-white">Konfirmasi Pemesanan</h2>
                <p class="text-sm text-slate-400 mt-1">Periksa kembali rincian booking Anda sebelum melanjutkan ke pembayaran.</p>
            </div>

            <!-- Summary Card -->
            <div class="space-y-6 mb-8 text-sm">
                <!-- Sesi / Paket -->
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-3 font-mono">Paket Pilihan</h3>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-white text-lg">{{ $package->name }}</span>
                        <span class="font-extrabold text-indigo-400 text-lg">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-slate-400 text-xs mt-1">{{ $package->description }}</p>
                </div>

                <!-- Waktu Sesi -->
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-3 font-mono">Jadwal Sesi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-slate-500 text-xs block">Tanggal Sesi</span>
                            <span class="text-white font-semibold text-sm">{{ \Carbon\Carbon::parse($sessionData['booking_date'])->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 text-xs block">Slot Waktu</span>
                            <span class="text-white font-semibold text-sm">{{ $sessionData['start_time'] }} - {{ $sessionData['end_time'] }} (WIB)</span>
                        </div>
                    </div>
                </div>

                <!-- Kontak User -->
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-3 font-mono">Data Diri Pemesan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b border-slate-900 pb-2">
                            <span class="text-slate-500">Nama Lengkap</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_name'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-900 pb-2">
                            <span class="text-slate-500">Email</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_email'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-900 pb-2">
                            <span class="text-slate-500">Nomor HP</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_phone'] }}</span>
                        </div>
                        @if(!empty($sessionData['notes']))
                        <div>
                            <span class="text-slate-500 block">Catatan Tambahan</span>
                            <p class="text-white bg-slate-900/60 p-3 rounded-xl border border-slate-850 mt-1.5 leading-relaxed">{{ $sessionData['notes'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="flex items-center justify-between pt-6 border-t border-slate-850">
                    <a href="{{ route('booking.step3') }}" class="text-sm font-semibold text-slate-400 hover:text-white">
                        Ubah Data Diri
                    </a>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-cyan-500 hover:from-indigo-600 hover:to-cyan-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02]">
                        Konfirmasi & Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
