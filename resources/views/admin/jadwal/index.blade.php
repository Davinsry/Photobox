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
                               min="{{ \Carbon\Carbon::today()->toDateString() }}" 
                               value="{{ old('blocked_date', $selectedDate) }}" required
                               onchange="window.location.href = '{{ route('admin.jadwal.index') }}?date=' + this.value"
                               class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                    </div>

                    <!-- Full day check -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_full_day" id="is_full_day" value="1" 
                               {{ old('is_full_day', '1') == '1' ? 'checked' : '' }}
                               onchange="document.getElementById('time-block-inputs').style.display = this.checked ? 'none' : 'block'"
                               class="rounded border-slate-800 text-indigo-500 focus:ring-indigo-500 bg-slate-950 w-4.5 h-4.5 cursor-pointer">
                        <label for="is_full_day" class="ml-2.5 text-xs font-semibold text-slate-300 cursor-pointer select-none">Blokir Sehari Penuh (Libur)</label>
                    </div>

                    <!-- Time slots block inputs -->
                    <div id="time-block-inputs" style="display: none;" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="start_time" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1.5 font-mono">Mulai Jam</label>
                                <input type="time" name="start_time" id="start_time" readonly
                                       class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-not-allowed">
                            </div>
                            <div>
                                <label for="end_time" class="block text-xxs font-bold uppercase tracking-wider text-slate-400 mb-1.5 font-mono">Selesai Jam</label>
                                <input type="time" name="end_time" id="end_time" readonly
                                       class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Real-time Slot Grid -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Pilih Slot Waktu Untuk Diblokir</label>
                            <p class="text-xxs text-slate-500 mb-3">Klik slot untuk memilih waktu mulai dan waktu selesai.</p>
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2" id="slot-grid-container">
                                @foreach($slots as $index => $slot)
                                    @php
                                        $btnClass = '';
                                        $statusText = '';
                                        $isDisabled = false;

                                        if ($slot['status'] === 'booked') {
                                            $btnClass = 'border-amber-500/30 bg-amber-950/20 text-amber-400 cursor-not-allowed';
                                            $statusText = $slot['info'];
                                            $isDisabled = true;
                                        } elseif ($slot['status'] === 'blocked') {
                                            $btnClass = 'border-rose-500/20 bg-rose-950/15 text-rose-400 cursor-not-allowed';
                                            $statusText = $slot['info'];
                                            $isDisabled = true;
                                        } elseif ($slot['status'] === 'past') {
                                            $btnClass = 'border-slate-850 bg-slate-900/40 text-slate-600 cursor-not-allowed';
                                            $statusText = $slot['info'];
                                            $isDisabled = true;
                                        } else {
                                            $btnClass = 'border-slate-800 bg-slate-950 hover:border-indigo-500/50 text-slate-300 cursor-pointer';
                                            $statusText = 'Tersedia';
                                        }
                                    @endphp
                                    <button type="button" 
                                            class="border rounded-xl p-2.5 text-center transition-all text-[10px] font-bold relative flex flex-col items-center justify-center gap-0.5 select-none admin-slot-btn {{ $btnClass }}"
                                            data-start="{{ $slot['start'] }}"
                                            data-end="{{ $slot['end'] }}"
                                            data-index="{{ $index }}"
                                            @if($isDisabled) disabled @endif>
                                        <span class="text-xs font-black">{{ $slot['start'] }}</span>
                                        <span class="text-[9px] opacity-70">{{ $slot['start'] }} - {{ $slot['end'] }}</span>
                                        <span class="text-[8px] font-medium tracking-tight mt-0.5 truncate max-w-full uppercase font-mono">{{ $statusText }}</span>
                                    </button>
                                @endforeach
                            </div>
                            
                            <button type="button" id="reset-selection-btn" class="mt-2.5 text-xxs text-indigo-400 hover:text-indigo-300 font-bold hidden flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"></path></svg>
                                Reset Pilihan Slot
                            </button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isFullDayCheckbox = document.getElementById('is_full_day');
    const timeBlockInputs = document.getElementById('time-block-inputs');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const slotButtons = document.querySelectorAll('.admin-slot-btn');
    const resetBtn = document.getElementById('reset-selection-btn');

    // Make sure initial state matches checkbox
    timeBlockInputs.style.display = isFullDayCheckbox.checked ? 'none' : 'block';
    
    isFullDayCheckbox.addEventListener('change', function() {
        timeBlockInputs.style.display = this.checked ? 'none' : 'block';
        if (this.checked) {
            resetSelection();
        }
    });

    let selectedStartIndex = null;
    let selectedEndIndex = null;

    slotButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));

            if (selectedStartIndex === null) {
                // First click: select start slot
                selectedStartIndex = index;
                selectedEndIndex = index;
            } else if (selectedStartIndex !== null && selectedEndIndex === selectedStartIndex) {
                // Second click: select end slot
                if (index < selectedStartIndex) {
                    selectedEndIndex = selectedStartIndex;
                    selectedStartIndex = index;
                } else {
                    selectedEndIndex = index;
                }
            } else {
                // Third click: reset and select new start slot
                selectedStartIndex = index;
                selectedEndIndex = index;
            }

            updateSlotHighlighting();
        });
    });

    resetBtn.addEventListener('click', function() {
        resetSelection();
    });

    function resetSelection() {
        selectedStartIndex = null;
        selectedEndIndex = null;
        startTimeInput.value = '';
        endTimeInput.value = '';
        updateSlotHighlighting();
    }

    function updateSlotHighlighting() {
        let hasSelection = selectedStartIndex !== null;
        
        if (hasSelection) {
            resetBtn.classList.remove('hidden');
            
            // Get start time and end time
            const startBtn = document.querySelector(`.admin-slot-btn[data-index="${selectedStartIndex}"]`);
            const endBtn = document.querySelector(`.admin-slot-btn[data-index="${selectedEndIndex}"]`);
            
            startTimeInput.value = startBtn.getAttribute('data-start');
            endTimeInput.value = endBtn.getAttribute('data-end');
        } else {
            resetBtn.classList.add('hidden');
            startTimeInput.value = '';
            endTimeInput.value = '';
        }

        slotButtons.forEach(btn => {
            if (btn.disabled) return;
            
            const index = parseInt(btn.getAttribute('data-index'));
            
            if (hasSelection && index >= selectedStartIndex && index <= selectedEndIndex) {
                // Highlight range
                btn.classList.remove('border-slate-800', 'bg-slate-950', 'text-slate-300', 'hover:border-indigo-500/50');
                btn.classList.add('border-indigo-500', 'bg-gradient-to-r', 'from-indigo-500/20', 'to-purple-600/20', 'text-white', 'ring-2', 'ring-indigo-500/20');
            } else {
                // Normal available slot style
                btn.classList.remove('border-indigo-500', 'bg-gradient-to-r', 'from-indigo-500/20', 'to-purple-600/20', 'text-white', 'ring-2', 'ring-indigo-500/20');
                btn.classList.add('border-slate-800', 'bg-slate-950', 'text-slate-300', 'hover:border-indigo-500/50');
            }
        });
    }
});
</script>
@endsection
