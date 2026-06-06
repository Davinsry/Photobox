@extends('layouts.main')

@section('title', 'Pemesanan Berhasil')

@section('content')
<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-xl mx-auto text-center">
        @if($booking->status == 'paid')
            <!-- Success Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mb-8 animate-bounce animate-duration-1000">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="text-4xl font-extrabold font-outfit text-white mb-2">Reservasi Berhasil!</h1>
            <p class="text-slate-400 text-xs max-w-sm mx-auto mb-8 leading-relaxed">Pembayaran Anda telah terkonfirmasi. Reservasi Anda berhasil diselesaikan.</p>
        @elseif($booking->status == 'cancelled')
            <!-- Cancelled / Expired Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 mb-8">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <h1 class="text-4xl font-extrabold font-outfit text-white mb-2">Waktu Pembayaran Habis</h1>
            <p class="text-slate-400 text-xs max-w-md mx-auto mb-8 leading-relaxed">Reservasi ini telah dibatalkan karena batas waktu pembayaran (5 menit) telah habis.</p>
        @elseif($booking->payment && $booking->payment->payment_method == 'cash')
            <!-- Cash Confirmed Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mb-8 animate-bounce animate-duration-1000">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h1 class="text-4xl font-extrabold font-outfit text-white mb-2">Reservasi Dibuat!</h1>
            <p class="text-slate-400 text-xs max-w-sm mx-auto mb-8 leading-relaxed">Reservasi Anda telah terdaftar. Silakan lakukan pembayaran di kasir saat kedatangan.</p>
        @else
            <!-- Pending Payment Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 mb-8">
                <svg class="w-10 h-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-4xl font-extrabold font-outfit text-white mb-2 font-black">Selesaikan Pembayaran</h1>
            <p class="text-slate-400 text-xs max-w-md mx-auto mb-4 leading-relaxed">Silakan selesaikan pembayaran Anda dalam waktu 5 menit.</p>
            <div class="mb-8">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/10 border border-amber-500/20 rounded-2xl text-amber-300 font-mono font-bold text-xs tracking-wider">
                    <svg class="w-4 h-4 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sisa Waktu Pembayaran: <span id="countdown">05:00</span>
                </span>
            </div>
        @endif

        <!-- Booking Details Card -->
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 text-left shadow-2xl shadow-black/35 mb-8">
            <div class="border-b border-white/[0.05] pb-5 mb-5 flex justify-between items-center">
                <div>
                    <span class="text-slate-500 text-[9px] font-black uppercase tracking-widest font-mono">KODE BOOKING</span>
                    <span class="text-2xl font-black text-white uppercase tracking-wider block mt-0.5">{{ $booking->booking_code }}</span>
                </div>
                <div>
                    @if($booking->status == 'paid')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Sudah Dibayar</span>
                    @elseif($booking->payment && $booking->payment->payment_method == 'cash')
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Bayar di Tempat</span>
                    @else
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Menunggu Pembayaran</span>
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
                    <span class="text-slate-500">Paket Layanan</span>
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
                <div class="flex justify-between border-t border-white/[0.05] pt-3">
                    <span class="text-slate-500">Metode Pembayaran</span>
                    <span class="text-white font-semibold uppercase font-mono">{{ $booking->payment->payment_method ?? 'QRIS' }}</span>
                </div>
                <div class="flex justify-between border-t border-white/[0.05] pt-5 mt-5">
                    <span class="text-slate-400 font-bold text-sm">Total Tagihan</span>
                    <span class="text-indigo-400 font-black text-base">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Developer Simulation & Instructions Box -->
            @if($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
            <div class="mt-6 border-t border-white/[0.05] pt-6 space-y-5">
                @if($booking->payment->payment_method === 'qris')
                    <!-- QRIS CARD -->
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10 text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-ping"></span>
                            <span class="text-[10px] font-bold tracking-wider text-indigo-300 font-mono uppercase">QRIS INSTANT</span>
                        </div>
                        <h4 class="text-white text-sm font-bold font-outfit mb-2">Scan QRIS Untuk Bayar</h4>
                        
                        <div class="bg-white p-4 rounded-2xl inline-block my-2 shadow-xl">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&color=0f4d43&data={{ $booking->booking_code }}" class="w-40 h-40 object-contain mx-auto" alt="QRIS Code">
                            <div class="text-[9px] text-emerald-950 font-black mt-2 tracking-widest font-mono">STUDIOKU JOGJA</div>
                        </div>
                        
                        <p class="text-slate-400 text-[10px] max-w-xs mx-auto mt-2 leading-relaxed">Scan QR Code di atas menggunakan aplikasi e-wallet (GoPay, OVO, Dana) atau Mobile Banking Anda.</p>
                    </div>
                @elseif($booking->payment->payment_method === 'transfer')
                    <!-- TRANSFER CARD -->
                    <div class="bg-white/5 rounded-2xl p-5 border border-white/10">
                        <div class="flex justify-between items-center mb-4">
                            <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-[10px] font-bold tracking-wider text-indigo-300 font-mono">TRANSFER BANK</span>
                            <span class="text-xs font-bold text-white uppercase tracking-wider font-mono">MOCKBANK</span>
                        </div>
                        <h4 class="text-white text-sm font-bold font-outfit mb-3">Informasi Rekening Pembayaran</h4>
                        
                        <div class="space-y-2 text-xs bg-slate-950/40 p-4 rounded-xl border border-white/5">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Nama Bank</span>
                                <span class="text-white font-bold">MockBank</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-medium">Nomor Rekening</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-indigo-400 font-black font-mono tracking-wider text-sm">{{ $booking->booking_code }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Atas Nama</span>
                                <span class="text-white font-semibold">Studioku Jogja</span>
                            </div>
                            <div class="flex justify-between border-t border-white/5 pt-2 mt-2">
                                <span class="text-slate-400">Jumlah Transfer</span>
                                <span class="text-white font-extrabold">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                            <!-- Refresh Status Button -->
                            <div class="mt-4">
                                <button onclick="window.location.reload();" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-indigo-500/15 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
                                    Refresh Status Pembayaran
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @elseif($booking->payment && $booking->payment->payment_method === 'cash')
            <div class="mt-6 border-t border-white/[0.05] pt-6">
                <div class="bg-indigo-500/5 rounded-2xl p-5 border border-indigo-500/15 text-center">
                    <h4 class="text-indigo-300 text-xs font-bold mb-1.5 font-outfit">Instruksi Pembayaran Cash</h4>
                    <p class="text-slate-300 text-[10px] leading-normal mb-1">Metode pembayaran Anda adalah <strong>Bayar di Tempat (Cash)</strong>.</p>
                    <p class="text-slate-400 text-[10px] leading-normal">Silakan melakukan pembayaran tunai atau QRIS langsung kepada kasir kami ketika Anda datang ke studio untuk sesi foto sesuai dengan jadwal yang telah Anda pilih.</p>
                </div>
            </div>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
            @if($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
                <button onclick="window.location.reload();" class="w-full px-6 py-3.5 bg-indigo-500 text-white font-bold rounded-2xl text-xs hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/25 text-center hover:scale-[1.02] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
                    Refresh Status
                </button>
            @endif
            <a href="{{ route('home') }}" class="w-full px-6 py-3.5 bg-white/5 border border-white/5 text-slate-300 font-bold rounded-2xl text-xs hover:bg-white/10 hover:text-white transition-all text-center flex items-center justify-center">
                Kembali ke Beranda
            </a>
            @if($booking->status != 'pending')
                <a href="{{ route('booking.cek.form') }}?booking_code={{ $booking->booking_code }}&guest_email={{ $booking->guest_email }}" class="w-full px-6 py-3.5 bg-indigo-500 text-white font-bold rounded-2xl text-xs hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/25 text-center hover:scale-[1.02] flex items-center justify-center">
                    Lihat Detail Status
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

@if($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
@section('scripts')
@php
    $remainingSeconds = 0;
    if ($booking->created_at) {
        $remainingSeconds = max(0, 300 - now()->diffInSeconds($booking->created_at));
    }
@endphp
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let remainingSeconds = {{ $remainingSeconds }};

        function updateTimer() {
            if (remainingSeconds <= 0) {
                clearInterval(timerInterval);
                document.getElementById("countdown").innerHTML = "00:00";
                window.location.reload();
            } else {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                
                const displayMinutes = minutes < 10 ? "0" + minutes : minutes;
                const displaySeconds = seconds < 10 ? "0" + seconds : seconds;
                
                document.getElementById("countdown").textContent = displayMinutes + ":" + displaySeconds;
                remainingSeconds--;
            }
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);

        // Poll payment status every 3 seconds to auto-reload once paid
        const checkStatusInterval = setInterval(async function() {
            try {
                const response = await fetch("/payment/api-check/{{ $booking->booking_code }}");
                if (response.ok) {
                    const data = await response.json();
                    if (data.payment_status === 'paid' || data.status === 'paid') {
                        clearInterval(checkStatusInterval);
                        clearInterval(timerInterval);
                        window.location.reload();
                    }
                }
            } catch (error) {
                console.error('Error polling status:', error);
            }
        }, 3000);
    });
</script>
@endsection
@endif

