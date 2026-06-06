@extends('layouts.main')

@section('title', 'Cek Status Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Status Search Card -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl mb-8">
            <div class="border-b border-slate-850 pb-6 mb-8 text-center">
                <h2 class="text-3xl font-bold font-outfit text-white">Cek Status Reservasi</h2>
                <p class="text-sm text-slate-400 mt-2">Masukkan kode booking unik dan email yang Anda gunakan saat checkout.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-6 py-4 rounded-2xl text-sm">
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
                               class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors uppercase">
                    </div>

                    <div>
                        <label for="guest_email" class="block text-sm font-semibold text-slate-300 mb-2">Alamat Email</label>
                        <input type="email" name="guest_email" id="guest_email" 
                               value="{{ old('guest_email', $booking->guest_email ?? '') }}"
                               placeholder="Contoh: customer@email.com"
                               required
                               class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-850">
                    <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02]">
                        Cari Reservasi
                    </button>
                </div>
            </form>
        </div>

        <!-- Result Card -->
        @if(isset($booking))
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
            <div class="border-b border-slate-850 pb-6 mb-8 flex justify-between items-center">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 font-mono">Kode Booking</span>
                    <h3 class="text-2xl font-bold font-outfit text-white tracking-wide uppercase">{{ $booking->booking_code }}</h3>
                </div>
                <div>
                    @if($booking->status == 'paid')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Sudah Dibayar</span>
                    @elseif($booking->status == 'completed')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Selesai Sesi</span>
                    @elseif($booking->status == 'cancelled')
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Dibatalkan</span>
                    @else
                        <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Menunggu Pembayaran</span>
                    @endif
                </div>
            </div>

            <!-- Detail List -->
            <div class="space-y-6 text-sm mb-8">
                <!-- Rincian Sesi -->
                <div class="grid grid-cols-2 gap-6 bg-slate-950 rounded-2xl p-5 border border-slate-850">
                    <div>
                        <span class="text-slate-500 text-xs block">Paket Layanan</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->package->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Durasi</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->package->duration_minutes }} Menit</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Tanggal Sesi</span>
                        <span class="text-white font-semibold text-sm">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Jam Sesi</span>
                        <span class="text-white font-semibold text-sm">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                    </div>
                </div>

                <!-- Data Pemesan -->
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850 space-y-3">
                    <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-2 font-mono">Informasi Pelanggan</h4>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Pelanggan</span>
                        <span class="text-white font-semibold">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Email</span>
                        <span class="text-white font-semibold">{{ $booking->guest_email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nomor HP</span>
                        <span class="text-white font-semibold">{{ $booking->guest_phone }}</span>
                    </div>
                    @if($booking->notes)
                    <div class="pt-2 border-t border-slate-900">
                        <span class="text-slate-500 block">Catatan Anda:</span>
                        <p class="text-slate-400 mt-1 italic leading-relaxed">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Rincian Pembayaran -->
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850">
                    <h4 class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-3 font-mono">Transaksi Pembayaran</h4>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-slate-500">Total Harga</span>
                        <span class="text-lg font-extrabold text-white">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                    </div>

                    @if($booking->status == 'pending')
                        <div class="bg-indigo-500/10 border border-indigo-500/30 rounded-xl p-4 text-center">
                            <p class="text-indigo-300 text-xs leading-relaxed mb-3">Ini adalah lingkungan pengembangan lokal. Anda dapat mensimulasikan pembayaran untuk mengubah status reservasi ini secara instan.</p>
                            
                            <form action="{{ route('payment.simulate', $booking->booking_code) }}" method="POST" class="inline-flex space-x-3 justify-center w-full">
                                @csrf
                                <button type="submit" name="simulate_status" value="paid" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition-colors">
                                    Simulasikan Sukses (Bayar)
                                </button>
                                <button type="submit" name="simulate_status" value="cancelled" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl transition-colors">
                                    Simulasikan Batal
                                </button>
                            </form>
                        </div>
                    @elseif($booking->status == 'paid')
                        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4 text-center">
                            <p class="text-emerald-300 text-xs font-medium">Pembayaran Berhasil! Silakan datang ke studio 10 menit sebelum jadwal sesi dimulai.</p>
                        </div>
                    @elseif($booking->status == 'cancelled')
                        <div class="bg-rose-500/10 border border-rose-500/30 rounded-xl p-4 text-center">
                            <p class="text-rose-300 text-xs font-medium">Reservasi ini telah dibatalkan.</p>
                        </div>
                    @elseif($booking->status == 'completed')
                        <div class="bg-indigo-500/10 border border-indigo-500/30 rounded-xl p-4 text-center">
                            <p class="text-indigo-300 text-xs font-medium">Sesi foto Anda sudah selesai. Terima kasih telah menggunakan jasa kami!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
