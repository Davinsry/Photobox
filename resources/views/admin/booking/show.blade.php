@extends('layouts.admin')

@section('page_title', 'Rincian Booking #' . $booking->booking_code)

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="flex items-center justify-between mb-2">
        <a href="{{ route('admin.booking.index') }}" class="text-xs font-semibold text-slate-400 hover:text-white flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Booking
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Main details -->
        <div class="md:col-span-2 space-y-6">
            <!-- Rincian Sesi -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 font-mono">Detail Sesi Reservasi</h3>
                
                <div class="grid grid-cols-2 gap-6 bg-slate-950 rounded-2xl p-5 border border-slate-850 text-sm">
                    <div>
                        <span class="text-slate-500 text-xs block">Paket Layanan</span>
                        <span class="text-white font-semibold">{{ $booking->package->name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Harga Paket</span>
                        <span class="text-white font-semibold">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Tanggal Sesi</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 text-xs block">Waktu Sesi</span>
                        <span class="text-white font-semibold">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                    </div>
                </div>
            </div>

            <!-- Kontak Guest -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 font-mono">Informasi Kontak Guest</h3>
                
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850 text-sm space-y-3">
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Nama Guest</span>
                        <span class="text-white font-semibold">{{ $booking->guest_name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Email</span>
                        <span class="text-white font-semibold">{{ $booking->guest_email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Nomor HP / WA</span>
                        <span class="text-white font-semibold">{{ $booking->guest_phone }}</span>
                    </div>
                    @if($booking->notes)
                    <div class="pt-2">
                        <span class="text-slate-500 block">Catatan Guest:</span>
                        <p class="text-slate-300 mt-1 italic bg-slate-900 p-3 rounded-xl border border-slate-850 leading-relaxed">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Rincian Transaksi -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 font-mono">Transaksi Pembayaran</h3>
                
                @if($booking->payment)
                <div class="bg-slate-950 rounded-2xl p-5 border border-slate-850 text-sm space-y-3">
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Total Tagihan</span>
                        <span class="text-white font-bold">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Status Pembayaran</span>
                        <span>
                            @if($booking->payment->status == 'paid')
                                <span class="text-emerald-400 font-bold">LUNAS</span>
                            @elseif($booking->payment->status == 'cancelled')
                                <span class="text-rose-400 font-bold">BATAL</span>
                            @elseif($booking->payment->status == 'bayar_di_tempat')
                                <span class="text-indigo-400 font-bold">BAYAR DI TEMPAT</span>
                            @else
                                <span class="text-amber-500 font-bold">PENDING</span>
                            @endif
                        </span>
                    </div>
                    @if($booking->payment->payment_method)
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">Metode Pembayaran</span>
                        <span class="text-white font-semibold uppercase">{{ $booking->payment->payment_method }}</span>
                    </div>
                    @endif
                    @if($booking->payment->transaction_id)
                    <div class="flex justify-between border-b border-slate-900 pb-2">
                        <span class="text-slate-500">ID Transaksi</span>
                        <span class="text-white font-mono text-xs font-semibold">{{ $booking->payment->transaction_id }}</span>
                    </div>
                    @endif
                    @if($booking->payment->paid_at)
                    <div class="flex justify-between">
                        <span class="text-slate-500">Waktu Bayar</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->translatedFormat('d M Y H:i:s') }} WIB</span>
                    </div>
                    @endif
                </div>
                @else
                <p class="text-xs text-slate-500">Tidak ada data transaksi pembayaran yang ditemukan.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar management -->
        <div class="md:col-span-1 space-y-6">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
                <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 font-mono">Kelola Status</h3>
                
                <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="status" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Status Reservasi</label>
                        <select name="status" id="status" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                            <option value="paid" {{ $booking->status == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed (Selesai Sesi)</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl text-xs transition-colors shadow-lg shadow-indigo-500/10">
                        Perbarui Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
