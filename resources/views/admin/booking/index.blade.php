@extends('layouts.admin')

@section('page_title', 'Kelola Reservasi Booking')

@section('content')
<div class="space-y-6 max-w-6xl">
    <!-- Filters & Export -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
        <form action="{{ route('admin.booking.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
            <!-- Filter Date -->
            <div>
                <label for="date" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Filter Tanggal</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}"
                       class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <!-- Filter Status -->
            <div>
                <label for="status" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Filter Status</label>
                <select name="status" id="status"
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                </select>
            </div>

            <!-- Filter Paket -->
            <div>
                <label for="package_id" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Filter Paket</label>
                <select name="package_id" id="package_id"
                        class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                    <option value="">Semua Paket</option>
                    @foreach($packages as $p)
                        <option value="{{ $p->id }}" {{ request('package_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-2">
                <button type="submit" class="flex-grow px-4 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl text-xs transition-colors shadow-lg shadow-indigo-500/10">
                    Filter
                </button>
                <a href="{{ route('admin.booking.index') }}" class="px-3 py-2.5 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-400 hover:text-white rounded-xl text-xs font-bold transition-colors">
                    Reset
                </a>
                <a href="{{ route('admin.booking.export', request()->all()) }}" class="px-3 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-colors shadow-lg shadow-emerald-500/10 flex items-center justify-center" title="Ekspor ke CSV/Excel">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Bookings List -->
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="border-b border-slate-850 text-slate-400 font-mono text-xs">
                        <th class="pb-3 font-semibold">Kode</th>
                        <th class="pb-3 font-semibold">Nama Guest</th>
                        <th class="pb-3 font-semibold">Kontak</th>
                        <th class="pb-3 font-semibold">Paket</th>
                        <th class="pb-3 font-semibold">Tanggal & Sesi</th>
                        <th class="pb-3 font-semibold">Status</th>
                        <th class="pb-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850/30">
                    @forelse($bookings as $booking)
                    <tr class="text-slate-300 hover:bg-slate-850/10 transition-colors">
                        <td class="py-4 font-bold text-white uppercase">{{ $booking->booking_code }}</td>
                        <td class="py-4 font-medium text-white">{{ $booking->guest_name }}</td>
                        <td class="py-4 text-xs">
                            <span class="block">{{ $booking->guest_email }}</span>
                            <span class="text-slate-500">{{ $booking->guest_phone }}</span>
                        </td>
                        <td class="py-4 font-medium">{{ $booking->package->name }}</td>
                        <td class="py-4 text-xs">
                            <span class="block text-slate-200 font-medium">{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d M Y') }}</span>
                            <span class="text-slate-500 font-mono">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</span>
                        </td>
                        <td class="py-4">
                            @if($booking->status == 'paid')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Paid</span>
                            @elseif($booking->status == 'completed')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">Completed</span>
                            @elseif($booking->status == 'cancelled')
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Cancelled</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20 animate-pulse">Pending</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('admin.booking.show', $booking->id) }}" class="px-3 py-1.5 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-300 rounded-xl text-xs font-bold transition-all">
                                Kelola
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-500 text-sm">Tidak ditemukan data booking yang cocok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 border-t border-slate-850 pt-4">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
