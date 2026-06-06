@extends('layouts.main')

@section('title', 'Konfirmasi Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Steps Progress Bar -->
    <div class="mb-16 max-w-3xl mx-auto bg-slate-950/40 backdrop-blur-md p-6 rounded-3xl border border-white/[0.05] shadow-lg shadow-black/20">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">1</span>
                <span>Pilih Paket</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">2</span>
                <span>Jadwal & Waktu</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">3</span>
                <span>Data Diri</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-9 h-9 rounded-2xl bg-indigo-500 text-white flex items-center justify-center mb-2 font-black shadow-lg shadow-indigo-500/20 ring-2 ring-indigo-500/20">4</span>
                <span class="font-bold">Konfirmasi</span>
            </div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 shadow-2xl shadow-black/30">
            <div class="border-b border-white/[0.05] pb-6 mb-8">
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-400 font-mono">Langkah Terakhir</span>
                <h2 class="text-3xl font-extrabold font-outfit text-white mt-1">Konfirmasi Pemesanan</h2>
                <p class="text-xs text-slate-400 mt-1.5">Periksa kembali rincian booking Anda sebelum melanjutkan ke pembayaran.</p>
            </div>

            <!-- Summary Card -->
            <div class="space-y-6 mb-8 text-sm">
                <!-- Sesi / Paket -->
                <div class="bg-slate-900/60 rounded-2xl p-5 border border-white/[0.05] shadow-inner">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-3 font-mono">Paket Pilihan</h3>
                    <div class="flex justify-between items-center">
                        <span class="font-extrabold text-white text-lg">{{ $package->name }}</span>
                        <span class="font-black text-indigo-400 text-lg">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-slate-400 text-xs mt-2 leading-relaxed">{{ $package->description }}</p>
                </div>

                <!-- Waktu Sesi -->
                <div class="bg-slate-900/60 rounded-2xl p-5 border border-white/[0.05] shadow-inner">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-3 font-mono">Jadwal Sesi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Tanggal Sesi</span>
                            <span class="text-white font-semibold text-sm">{{ \Carbon\Carbon::parse($sessionData['booking_date'])->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Slot Waktu</span>
                            <span class="text-white font-semibold text-sm">{{ $sessionData['start_time'] }} - {{ $sessionData['end_time'] }} (WIB)</span>
                        </div>
                    </div>
                </div>

                <!-- Kontak User -->
                <div class="bg-slate-900/60 rounded-2xl p-5 border border-white/[0.05] shadow-inner">
                    <h3 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-4 font-mono">Data Diri Pemesan</h3>
                    <div class="space-y-3.5">
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-slate-500">Nama Lengkap</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_name'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-slate-500">Email</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_email'] }}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-slate-500">Nomor HP</span>
                            <span class="text-white font-semibold">{{ $sessionData['guest_phone'] }}</span>
                        </div>
                        @if(!empty($sessionData['notes']))
                        <div class="pt-2">
                            <span class="text-slate-500 text-xs block mb-1">Catatan Tambahan:</span>
                            <p class="text-slate-400 bg-slate-950/40 p-3.5 rounded-xl border border-white/5 leading-relaxed text-xs italic">{{ $sessionData['notes'] }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div class="flex items-center justify-between pt-6 border-t border-white/[0.05] gap-4">
                    <a href="{{ route('booking.step3') }}" class="text-xs font-bold text-slate-400 hover:text-white bg-white/5 px-4 py-2.5 border border-white/5 rounded-xl transition-all hover:scale-[1.02]">
                        Ubah Data Diri
                    </a>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-sm rounded-2xl transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:scale-[1.02] active:scale-[0.98]">
                        Konfirmasi & Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
