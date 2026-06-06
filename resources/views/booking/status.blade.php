@extends('layouts.main')

@section('title', 'Cek Status Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-2xl mx-auto">
        <!-- Status Search Card -->
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 shadow-2xl shadow-black/30 mb-8">
            <div class="border-b border-white/[0.05] pb-6 mb-8 text-center">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Status Reservasi</span>
                <h2 class="text-3xl font-extrabold font-outfit text-white mt-1">Cek Status Reservasi</h2>
                <div class="w-12 h-1 bg-indigo-500 mx-auto rounded-full mt-3"></div>
                <p class="text-xs text-slate-400 mt-3">Masukkan kode booking unik dan email yang Anda gunakan saat checkout.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('booking.cek.submit') }}" method="POST">
                @csrf
                <div class="space-y-6 mb-8">
                    <div>
                        <label for="booking_code" class="block text-sm font-semibold text-slate-300 mb-2">Kode Booking</label>
                        <input type="text" name="booking_code" id="booking_code" 
                               value="{{ old('booking_code', $booking->booking_code ?? '') }}"
                               placeholder="Contoh: SB-XXXXXX"
                               required
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors uppercase">
                    </div>

                    <div>
                        <label for="guest_email" class="block text-sm font-semibold text-slate-300 mb-2">Alamat Email</label>
                        <input type="email" name="guest_email" id="guest_email" 
                               value="{{ old('guest_email', $booking->guest_email ?? '') }}"
                               placeholder="Contoh: customer@email.com"
                               required
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-white/[0.05]">
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-sm rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-[0.98]">
                        Cari Reservasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Result Card -->
        @if(isset($booking))
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 shadow-2xl shadow-black/30">
            <div class="border-b border-white/[0.05] pb-6 mb-8 flex justify-between items-center gap-4">
                <div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 font-mono">Kode Booking</span>
                    <h3 class="text-2xl font-black font-outfit text-white tracking-wide uppercase mt-0.5">{{ $booking->booking_code }}</h3>
                </div>
                <div>
                    @if($booking->status == 'paid')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Sudah Dibayar</span>
                    @elseif($booking->status == 'completed')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Selesai Sesi</span>
                    @elseif($booking->status == 'cancelled')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                    @elseif($booking->payment && $booking->payment->payment_method == 'cash')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Bayar di Tempat</span>
                    @else
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Menunggu Pembayaran</span>
                    @endif
                </div>
            </div>

            @if($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
                <div class="mb-8 bg-amber-500/10 border border-amber-500/20 rounded-2xl p-5 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="flex items-center gap-3 text-left">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 flex-shrink-0 animate-pulse">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white">Selesaikan Pembayaran Anda</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">Silakan selesaikan pembayaran sebelum batas waktu berakhir.</p>
                        </div>
                    </div>
                    <div>
                        <span class="inline-flex items-center gap-2 px-3.5 py-2 bg-amber-500/20 rounded-xl text-amber-300 font-mono font-black text-xs tracking-wider">
                            Sisa Waktu: <span id="countdown">05:00</span>
                        </span>
                    </div>
                </div>
            @endif

            <!-- Detail List -->
            <div class="space-y-6 text-sm mb-8">
                <!-- Rincian Sesi -->
                <div class="grid grid-cols-2 gap-6 bg-slate-900/40 rounded-2xl p-5 border border-white/[0.05] shadow-inner">
                    <div>
                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Paket Layanan</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->package->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Durasi Sesi</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->package->duration_minutes }} Menit</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Tanggal Sesi</span>
                        <span class="text-white font-semibold text-sm">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider block">Jam Sesi</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                    </div>
                </div>

                <!-- Data Pemesan -->
                <div class="bg-slate-900/40 rounded-2xl p-5 border border-white/[0.05] shadow-inner space-y-3">
                    <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-3 font-mono">Informasi Pelanggan</h4>
                    <div class="flex justify-between border-b border-white/5 pb-2 text-xs">
                        <span class="text-slate-500">Nama Pelanggan</span>
                        <span class="text-white font-semibold">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-white/5 pb-2 text-xs">
                        <span class="text-slate-500">Email</span>
                        <span class="text-white font-semibold">{{ $booking->guest_email }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-500">Nomor HP</span>
                        <span class="text-white font-semibold">{{ $booking->guest_phone }}</span>
                    </div>
                    @if($booking->notes)
                    <div class="pt-3 border-t border-white/5 text-xs">
                        <span class="text-slate-500 block mb-1">Catatan Anda:</span>
                        <p class="text-slate-400 italic leading-relaxed">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Rincian Pembayaran -->
                <div class="bg-slate-900/40 rounded-2xl p-5 border border-white/[0.05] shadow-inner">
                    <h4 class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-3 font-mono">Transaksi Pembayaran</h4>
                    <div class="flex justify-between items-center mb-2 text-xs">
                        <span class="text-slate-500">Metode Pembayaran</span>
                        <span class="text-white font-semibold uppercase font-mono">{{ $booking->payment->payment_method ?? 'QRIS' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 text-xs border-t border-white/5 pt-2">
                        <span class="text-slate-500">Total Harga</span>
                        <span class="text-lg font-black text-white">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
                        <div class="mt-4 space-y-4">
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
                                    
                                    <p class="text-slate-400 text-[10px] max-w-xs mx-auto mt-2 leading-relaxed">Scan QR Code di atas menggunakan aplikasi e-wallet (GoPay, OVO, Dana) or Mobile Banking Anda.</p>
                                </div>
                            @elseif($booking->payment->payment_method === 'transfer')
                                <!-- TRANSFER CARD -->
                                <div class="bg-white/5 rounded-2xl p-5 border border-white/10 text-left">
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
                                            <div class="flex items-center gap-2">
                                                <span class="text-indigo-400 font-black font-mono tracking-wider text-sm">{{ $booking->booking_code }}</span>
                                                <button onclick="navigator.clipboard.writeText('{{ $booking->booking_code }}'); const btn = this; const origSvg = btn.innerHTML; btn.innerHTML = '<span class=\'text-[10px] text-emerald-400 font-bold px-1\'>Tersalin!</span>'; setTimeout(() => btn.innerHTML = origSvg, 2000);" class="p-1 text-slate-400 hover:text-white transition-colors bg-white/5 hover:bg-white/10 rounded-md border border-white/5 flex items-center justify-center gap-1" title="Salin Nomor Rekening">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m-3 8h4m-4 4h4m-11-4h.01M3 16h.01"></path>
                                                    </svg>
                                                </button>
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
                                    
                                    <p class="text-slate-400 text-[10px] mt-3 leading-relaxed text-center">Silakan buka aplikasi <strong>MockBank</strong>, masuk ke menu <strong>Bayar &gt; Studioku</strong>, masukkan nomor rekening pembayaran (Kode Booking) di atas, lalu selesaikan transaksi.</p>
                                </div>
                            @endif
                            
                            <!-- Refresh Button for Pending Payments -->
                            <div class="mt-4">
                                <button onclick="window.location.reload();" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-indigo-500/15 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.5"></path></svg>
                                    Refresh Status Pembayaran
                                </button>
                            </div>
                        </div>
                    @elseif($booking->status == 'pending' && $booking->payment && $booking->payment->payment_method === 'cash')
                        <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-center mt-4">
                            <p class="text-indigo-300 text-xs font-semibold">Silakan lakukan pembayaran tunai atau QRIS secara langsung kepada kasir di studio saat sesi foto Anda berlangsung.</p>
                        </div>
                    @elseif($booking->status == 'paid')
                        <div class="bg-emerald-500/5 border border-emerald-500/20 rounded-xl p-4 text-center">
                            <p class="text-emerald-400 text-xs font-semibold">Pembayaran Berhasil! Silakan datang ke studio 10 menit sebelum jadwal sesi dimulai.</p>
                        </div>
                    @elseif($booking->status == 'cancelled')
                        <div class="bg-rose-500/5 border border-rose-500/20 rounded-xl p-4 text-center">
                            <p class="text-rose-400 text-xs font-semibold">Reservasi ini telah dibatalkan.</p>
                        </div>
                    @elseif($booking->status == 'completed')
                        <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-xl p-4 text-center">
                            <p class="text-indigo-300 text-xs font-semibold">Sesi foto Anda sudah selesai. Terima kasih telah menggunakan jasa kami!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@if(isset($booking) && $booking->status == 'pending' && $booking->payment && $booking->payment->payment_method !== 'cash')
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

