@extends('layouts.admin')

@section('page_title', 'Kelola Jadwal & Jam Operasional')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl">
    <!-- Block & Operational Forms -->
    <div class="lg:col-span-1 space-y-8">
        <!-- Operating Hours Form -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
            <div class="border-b border-slate-850 pb-4 mb-6">
                <h3 class="text-lg font-bold font-outfit text-white">Jam Operasional</h3>
                <p class="text-xs text-slate-400 mt-1">Mengatur jam buka dan tutup studio untuk generate slot otomatis.</p>
            </div>

            <form action="{{ route('admin.jadwal.saveSettings') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <div>
                        <label for="opening_time" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Jam Buka Studio</label>
                        <input type="time" name="opening_time" id="opening_time" 
                               value="{{ $openingTime }}" required
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="closing_time" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Jam Tutup Studio</label>
                        <input type="time" name="closing_time" id="closing_time" 
                               value="{{ $closingTime }}" required
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl text-xs transition-colors shadow-lg shadow-indigo-500/10">
                    Simpan Jam Operasional
                </button>
            </form>
        </div>

        <!-- Block Slots Form -->
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg">
            <div class="border-b border-slate-850 pb-4 mb-6">
                <h3 class="text-lg font-bold font-outfit text-white">Blokir Jadwal / Slot</h3>
                <p class="text-xs text-slate-400 mt-1">Blokir tanggal atau slot jam tertentu (libur, maintenance, event).</p>
            </div>

            @if($errors->any())
                <div class="mb-4 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-4 py-2.5 rounded-xl text-xs">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.jadwal.block') }}" method="POST">
                @csrf
                <div class="space-y-4 mb-6">
                    <!-- Date -->
                    <div>
                        <label for="blocked_date" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Tanggal Blokir</label>
                        <input type="date" name="blocked_date" id="blocked_date" 
                               min="{{ \Carbon\Carbon::today()->toDateString() }}" required
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Full day check -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_full_day" id="is_full_day" value="1" checked
                               onchange="document.getElementById('time-block-inputs').style.display = this.checked ? 'none' : 'grid'"
                               class="rounded border-slate-800 text-indigo-500 focus:ring-indigo-500 bg-slate-950 w-4.5 h-4.5 cursor-pointer">
                        <label for="is_full_day" class="ml-2.5 text-xs font-semibold text-slate-300 cursor-pointer select-none">Blokir Sehari Penuh (Libur)</label>
                    </div>

                    <!-- Time slots block inputs -->
                    <div id="time-block-inputs" class="grid grid-cols-2 gap-4" style="display: none;">
                        <div>
                            <label for="start_time" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1.5 font-mono">Mulai Jam</label>
                            <input type="time" name="start_time" id="start_time" 
                                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>
                        <div>
                            <label for="end_time" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1.5 font-mono">Selesai Jam</label>
                            <input type="time" name="end_time" id="end_time" 
                                   class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Alasan Blokir</label>
                        <input type="text" name="reason" id="reason" placeholder="Contoh: Maintenance AC, Libur Lebaran..."
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl text-xs transition-colors shadow-lg shadow-rose-500/10">
                    Blokir Slot Jadwal
                </button>
            </form>
        </div>
    </div>

    <!-- Block List -->
    <div class="lg:col-span-2 space-y-6">
        <h3 class="text-lg font-bold font-outfit text-white">Daftar Jadwal Diblokir</h3>
        
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="border-b border-slate-850 text-slate-400 font-mono text-xs">
                            <th class="pb-3 font-semibold">Tanggal</th>
                            <th class="pb-3 font-semibold">Waktu Blokir</th>
                            <th class="pb-3 font-semibold">Alasan</th>
                            <th class="pb-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-850/30">
                        @forelse($blockedSchedules as $block)
                        <tr class="text-slate-300">
                            <td class="py-4 font-semibold text-white">
                                {{ \Carbon\Carbon::parse($block->blocked_date)->translatedFormat('d F Y') }}
                            </td>
                            <td class="py-4 font-mono text-xs">
                                @if(is_null($block->start_time) && is_null($block->end_time))
                                    <span class="px-2 py-0.5 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20 font-bold font-sans">Sehari Penuh</span>
                                @else
                                    {{ $block->start_time }} - {{ $block->end_time }} WIB
                                @endif
                            </td>
                            <td class="py-4 text-xs">{{ $block->reason }}</td>
                            <td class="py-4 text-right">
                                <form action="{{ route('admin.jadwal.destroyBlock', $block->id) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin membuka kembali slot ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-400 hover:text-white rounded-xl text-xs font-bold transition-all">
                                        Buka Blokir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-500 text-sm">Tidak ada jadwal yang sedang diblokir.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
