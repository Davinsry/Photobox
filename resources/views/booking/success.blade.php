@extends('layouts.main')

@section('title', 'Pemesanan Berhasil')

@section('content')
<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto text-center">
        <!-- Success Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mb-8 animate-bounce">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="text-4xl font-extrabold font-outfit text-white mb-2">Reservasi Dibuat!</h1>
        <p class="text-slate-400 text-sm max-w-sm mx-auto mb-8">Reservasi Anda telah terdaftar di sistem. Silakan simpan kode booking Anda.</p>

        <!-- Booking Details Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 text-left shadow-xl mb-8">
            <div class="border-b border-slate-850 pb-4 mb-4 flex justify-between items-center">
                <div>
                    <span class="text-slate-500 text-xs block font-mono">KODE BOOKING</span>
                    <span class="text-2xl font-black text-white uppercase tracking-wider">{{ $booking->booking_code }}</span>
                </div>
                <div>
                    @if($booking->status == 'paid')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Sudah Dibayar</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Menunggu Pembayaran</span>
                    @endif
                </div>
            </div>

            <!-- Details -->
            <div class="space-y-4 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-500">Nama Pelanggan</span>
                    <span class="text-white font-semibold">{{ $booking->guest_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Email</span>
                    <span class="text-white font-semibold">{{ $booking->guest_email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Paket</span>
                    <span class="text-white font-semibold">{{ $booking->package->name }} ({{ $booking->package->duration_minutes }} Menit)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal</span>
                    <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jam Sesi</span>
                    <span class="text-white font-semibold">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                </div>
                <div class="flex justify-between border-t border-slate-850 pt-4 mt-4">
                    <span class="text-slate-400 font-bold text-sm">Total Tagihan</span>
                    <span class="text-indigo-400 font-extrabold text-sm">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Developer Simulation Box -->
            @if($booking->status == 'pending')
            <div class="mt-6 border-t border-slate-850 pt-6">
                <div class="bg-indigo-500/5 rounded-2xl p-4 border border-indigo-500/15 text-center">
                    <h4 class="text-indigo-300 text-xs font-bold mb-2">Simulasi Pembayaran (Local Dev)</h4>
                    <p class="text-slate-400 text-xxs mb-4 leading-normal">Untuk mempermudah pengujian alur kerja tanpa perlu integrasi payment gateway live, silakan klik tombol di bawah ini:</p>
                    
                    <form action="{{ route('payment.simulate', $booking->booking_code) }}" method="POST" class="inline-flex space-x-2">
                        @csrf
                        <button type="submit" name="simulate_status" value="paid" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl transition-all">
                            Bayar Sekarang (Simulasi)
                        </button>
                        <button type="submit" name="simulate_status" value="cancelled" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white text-xs font-bold rounded-xl transition-all">
                            Batalkan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 justify-center">
            <a href="{{ route('home') }}" class="px-6 py-3.5 bg-slate-900 border border-slate-800 text-slate-300 font-semibold rounded-2xl text-sm hover:bg-slate-800 transition-all">
                Kembali ke Beranda
            </a>
            <a href="{{ route('booking.cek.form') }}?booking_code={{ $booking->booking_code }}&guest_email={{ $booking->guest_email }}" class="px-6 py-3.5 bg-indigo-500 text-white font-semibold rounded-2xl text-sm hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/10">
                Lihat Detail Status
            </a>
        </div>
    </div>
</div>
@endsection
