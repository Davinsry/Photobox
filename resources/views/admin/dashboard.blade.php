@extends('layouts.admin')

@section('page_title', 'Dashboard Statistik')

@section('content')
<div class="space-y-8 max-w-6xl">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 relative overflow-hidden shadow-lg">
            <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Booking Hari Ini</span>
            <span class="block text-3xl font-extrabold text-white font-outfit">{{ $bookingsToday }}</span>
            <div class="absolute right-6 bottom-6 text-indigo-500/15">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 relative overflow-hidden shadow-lg">
            <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Booking Bulan Ini</span>
            <span class="block text-3xl font-extrabold text-white font-outfit">{{ $bookingsThisMonth }}</span>
            <div class="absolute right-6 bottom-6 text-indigo-500/15">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 relative overflow-hidden shadow-lg col-span-1 sm:col-span-2 lg:col-span-2">
            <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pendapatan Bulan Ini (Lunas/Selesai)</span>
            <span class="block text-3xl font-extrabold text-indigo-400 font-outfit">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</span>
            <div class="absolute right-6 bottom-6 text-indigo-500/10">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16v1M10 8h4m-4 8h4"></path></svg>
            </div>
        </div>
    </div>

    <!-- Status Breakdown -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4 font-mono">Status Reservasi Keseluruhan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-850">
                <span class="text-xs text-slate-500 block">Menunggu Bayar</span>
                <span class="text-xl font-bold text-amber-500 mt-1 block">{{ $statusSummary['pending'] }}</span>
            </div>
            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-850">
                <span class="text-xs text-slate-500 block">Lunas (Paid)</span>
                <span class="text-xl font-bold text-emerald-500 mt-1 block">{{ $statusSummary['paid'] }}</span>
            </div>
            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-850">
                <span class="text-xs text-slate-500 block">Selesai Sesi</span>
                <span class="text-xl font-bold text-indigo-400 mt-1 block">{{ $statusSummary['completed'] }}</span>
            </div>
            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-850">
                <span class="text-xs text-slate-500 block">Dibatalkan</span>
                <span class="text-xl font-bold text-rose-500 mt-1 block">{{ $statusSummary['cancelled'] }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold font-outfit text-white">Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300">
                Lihat Semua Booking &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-850 text-slate-400 font-mono text-xs">
                        <th class="pb-3 font-semibold">Kode Booking</th>
                        <th class="pb-3 font-semibold">Nama Guest</th>
                        <th class="pb-3 font-semibold">Paket</th>
                        <th class="pb-3 font-semibold">Tanggal & Waktu</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850/30">
                    @forelse($recentBookings as $booking)
                    <tr class="text-slate-300">
                        <td class="py-4 font-bold text-white uppercase">{{ $booking->booking_code }}</td>
                        <td class="py-4">{{ $booking->guest_name }}</td>
                        <td class="py-4 font-medium">{{ $booking->package->name }}</td>
                        <td class="py-4">
                            <span class="block">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</span>
                            <span class="text-xs text-slate-500">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                        </td>
                        <td class="py-4">
                            @if($booking->status == 'paid')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Paid</span>
                            @elseif($booking->status == 'completed')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Completed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Cancelled</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">Pending</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="px-3 py-1.5 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-300 rounded-xl text-xs font-bold transition-all">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 text-sm">Belum ada data booking yang masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
