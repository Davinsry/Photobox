@extends('layouts.main')

@section('title', 'Pemesanan Berhasil')

@section('content')
<div class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-xl mx-auto text-center">
        <!-- Success Icon -->
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 mb-8 animate-bounce">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <h1 class="text-4xl font-extrabold font-outfit text-white mb-2">Reservasi Dibuat!</h1>
        <p class="text-slate-400 text-xs max-w-sm mx-auto mb-8 leading-relaxed">Reservasi Anda telah terdaftar di sistem. Silakan simpan kode booking Anda di bawah.</p>

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
                        
                        <p class="text-slate-400 text-[10px] mt-3 leading-relaxed text-center">Silakan buka aplikasi <strong>MockBank</strong>, masuk ke menu <strong>Bayar &gt; Studioku</strong>, masukkan nomor rekening pembayaran (Kode Booking) di atas, lalu selesaikan transaksi.</p>
                    </div>
                @endif

                <!-- Developer Local Simulation Option -->
                <div class="bg-indigo-500/5 rounded-2xl p-5 border border-indigo-500/15 text-center">
                    <h4 class="text-indigo-300 text-xs font-bold mb-1.5 font-outfit">Simulasi Pembayaran (Local Dev)</h4>
                    <p class="text-slate-400 text-[10px] mb-4 leading-normal">Gunakan tombol simulasi di bawah jika Anda ingin membayar langsung tanpa melalui MockBank:</p>
                    
                    <form action="{{ route('payment.simulate', $booking->booking_code) }}" method="POST" class="flex flex-col sm:flex-row justify-center gap-3">
                        @csrf
                        <button type="submit" name="simulate_status" value="paid" class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl transition-all shadow-md shadow-emerald-500/15 hover:scale-[1.02]">
                            Bayar Sekarang (Simulasi)
                        </button>
                        <button type="submit" name="simulate_status" value="cancelled" class="w-full px-4 py-2.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-bold rounded-xl border border-rose-500/20 transition-all hover:scale-[1.02]">
                            Batalkan
                        </button>
                    </form>
                </div>
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

        <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-sm mx-auto">
            <a href="{{ route('home') }}" class="w-full px-6 py-3.5 bg-white/5 border border-white/5 text-slate-300 font-bold rounded-2xl text-xs hover:bg-white/10 hover:text-white transition-all text-center">
                Kembali ke Beranda
            </a>
            <a href="{{ route('booking.cek.form') }}?booking_code={{ $booking->booking_code }}&guest_email={{ $booking->guest_email }}" class="w-full px-6 py-3.5 bg-indigo-500 text-white font-bold rounded-2xl text-xs hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-500/25 text-center hover:scale-[1.02]">
                Lihat Detail Status
            </a>
        </div>
    </div>
</div>
@endsection
