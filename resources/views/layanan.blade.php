@extends('layouts.main')

@section('title', 'Layanan')

@section('content')
    <section class="py-16 relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] opacity-10 bg-indigo-500 blur-[100px] rounded-full mix-blend-screen pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Paket Layanan Kami</h1>
                <p class="text-lg text-slate-400">Temukan sesi foto studio dan photobox premium dengan pencahayaan terbaik di Jogja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($packages as $package)
                <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 hover:border-indigo-500/50 transition-all duration-300 group flex flex-col h-full hover:shadow-2xl hover:shadow-indigo-500/5">
                    @if($package->thumbnail)
                        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-full h-56 object-cover rounded-2xl mb-6 border border-slate-800">
                    @else
                        <div class="w-full h-56 bg-gradient-to-br from-indigo-900/30 to-slate-800 rounded-2xl mb-6 flex items-center justify-center border border-slate-800">
                            <svg class="w-16 h-16 text-indigo-400/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-2xl font-bold mb-2 text-white">{{ $package->name }}</h3>
                    <p class="text-slate-400 mb-6 flex-grow leading-relaxed">{{ $package->description }}</p>
                    
                    <div class="flex items-baseline mb-8">
                        <span class="text-4xl font-extrabold text-white">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    </div>

                    <ul class="space-y-4 mb-8 text-sm border-t border-slate-800 pt-6">
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Durasi Sesi: {{ $package->duration_minutes }} Menit
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Instant Digital Delivery (Semua softfile didapatkan)
                        </li>
                        <li class="flex items-center text-slate-300">
                            <svg class="w-5 h-5 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Studio Backgrounds Pilihan
                        </li>
                    </ul>
                    
                    <a href="{{ route('booking.step2', ['package_id' => $package->id]) }}" class="block w-full py-4 px-6 rounded-2xl bg-indigo-500 text-white font-bold text-center hover:bg-indigo-600 transition-all mt-auto shadow-lg shadow-indigo-500/20">
                        Pilih & Lanjut Jadwal
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada paket layanan aktif.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
