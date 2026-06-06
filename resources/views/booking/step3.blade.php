@extends('layouts.main')

@section('title', 'Data Diri - Booking')

@section('content')
<div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Steps Progress Bar -->
    <div class="mb-16 max-w-3xl mx-auto bg-slate-950/40 backdrop-blur-md p-6 rounded-3xl border border-white/[0.05] shadow-lg shadow-black/20">
        <div class="flex items-center justify-between text-xs sm:text-sm text-slate-400 font-medium font-outfit">
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">1</span>
                <span>Pilih Paket</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">2</span>
                <span>Jadwal & Waktu</span>
            </div>
            <div class="h-[2px] bg-indigo-500/30 flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center text-indigo-400">
                <span class="w-9 h-9 rounded-2xl bg-indigo-500 text-white flex items-center justify-center mb-2 font-black shadow-lg shadow-indigo-500/20 ring-2 ring-indigo-500/20">3</span>
                <span class="font-bold">Data Diri</span>
            </div>
            <div class="h-[2px] bg-white/[0.05] flex-grow -mt-6 mx-4 rounded-full"></div>
            <div class="flex flex-col items-center">
                <span class="w-9 h-9 rounded-2xl bg-slate-900 border border-white/[0.05] text-slate-400 flex items-center justify-center mb-2 font-bold">4</span>
                <span>Konfirmasi</span>
            </div>
        </div>
    </div>

    <div class="max-w-xl mx-auto">
        <div class="bg-slate-950/40 backdrop-blur-md border border-white/[0.05] rounded-3xl p-8 shadow-2xl shadow-black/30">
            <div class="border-b border-white/[0.05] pb-6 mb-8 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-indigo-400 font-mono">Langkah 03</span>
                    <h2 class="text-2xl font-extrabold font-outfit text-white mt-1">Data Kontak Anda</h2>
                    <p class="text-xs text-slate-400 mt-1.5">Gunakan guest checkout tanpa pendaftaran akun.</p>
                </div>
                <a href="{{ route('booking.step2') }}" class="text-xs font-bold text-slate-400 hover:text-white flex items-center bg-white/5 px-3 py-1.5 border border-white/5 rounded-xl transition-all hover:scale-[1.02]">
                    Kembali
                </a>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-6 py-4 rounded-2xl text-sm font-medium">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.step3') }}" method="POST">
                @csrf

                <div class="space-y-6 mb-8">
                    <div>
                        <label for="guest_name" class="block text-sm font-semibold text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="guest_name" id="guest_name" 
                               value="{{ old('guest_name', $sessionData['guest_name'] ?? '') }}"
                               placeholder="Contoh: Davin Sry"
                               required
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="guest_email" class="block text-sm font-semibold text-slate-300 mb-2">Alamat Email</label>
                        <input type="email" name="guest_email" id="guest_email" 
                               value="{{ old('guest_email', $sessionData['guest_email'] ?? '') }}"
                               placeholder="Contoh: customer@email.com"
                               required
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                        <span class="text-[10px] text-slate-500 font-medium mt-2 block">Kode booking dan bukti pembayaran akan dikirim ke email ini.</span>
                    </div>

                    <div>
                        <label for="guest_phone" class="block text-sm font-semibold text-slate-300 mb-2">Nomor HP / WhatsApp</label>
                        <input type="text" name="guest_phone" id="guest_phone" 
                               value="{{ old('guest_phone', $sessionData['guest_phone'] ?? '') }}"
                               placeholder="Contoh: 08123456789"
                               required
                               class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-300 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  placeholder="Tuliskan permintaan khusus Anda jika ada..."
                                  class="w-full bg-slate-900 border border-white/[0.05] rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors resize-none">{{ old('notes', $sessionData['notes'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-white/[0.05]">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold text-sm rounded-2xl transition-all shadow-lg shadow-indigo-500/20 hover:scale-[1.02] active:scale-[0.98]">
                        Lanjut ke Ringkasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
