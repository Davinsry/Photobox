@extends('layouts.admin')

@section('page_title', 'Kelola Paket Layanan')

@section('content')
<div class="space-y-6 max-w-6xl">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold font-outfit text-white">Daftar Paket</h2>
        <a href="{{ route('admin.layanan.create') }}" class="px-5 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl text-xs transition-all shadow-lg shadow-indigo-500/25">
            + Tambah Paket Baru
        </a>
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($packages as $package)
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col hover:border-slate-700 transition-all relative group shadow-lg">
            <!-- Status Badge -->
            <div class="absolute top-4 right-4">
                @if($package->is_active)
                    <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aktif</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-rose-500/10 text-rose-400 border border-rose-500/20">Nonaktif</span>
                @endif
            </div>

            <!-- Thumbnail -->
            @if($package->thumbnail)
                <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-40 object-cover rounded-2xl mb-4 border border-slate-800">
            @else
                <div class="w-full h-40 bg-slate-950 rounded-2xl mb-4 flex items-center justify-center border border-slate-800">
                    <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif

            <h3 class="text-xl font-bold font-outfit text-white mb-2">{{ $package->name }}</h3>
            <p class="text-sm text-slate-400 mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>

            <div class="flex justify-between items-baseline mb-6 border-t border-slate-850 pt-4">
                <span class="text-xs text-slate-500 font-mono">Durasi: {{ $package->duration_minutes }} Min</span>
                <span class="text-2xl font-extrabold text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3 mt-auto">
                <a href="{{ route('admin.layanan.edit', $package->id) }}" class="flex-grow py-3 px-4 rounded-xl bg-slate-950 hover:bg-slate-850 border border-slate-850 hover:border-slate-700 text-slate-300 font-bold text-center text-xs transition-all">
                    Edit Paket
                </a>
                <form action="{{ route('admin.layanan.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?')" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-3 px-4 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-400 hover:text-white border border-rose-500/20 transition-all text-xs font-bold">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-slate-900 border border-slate-800 rounded-3xl">
            <p class="text-slate-400 text-sm">Belum ada paket layanan. Silakan tambah paket baru.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
