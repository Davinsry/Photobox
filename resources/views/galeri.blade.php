@extends('layouts.main')

@section('title', 'Galeri')

@section('content')
    <section class="py-16 relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] opacity-10 bg-indigo-500 blur-[100px] rounded-full mix-blend-screen pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Galeri Foto</h1>
                <p class="text-lg text-slate-400">Inspirasi pose, ekspresi, dan keceriaan dari customer setia kami.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($galleries as $gallery)
                <div class="group relative rounded-3xl overflow-hidden aspect-[3/4] bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all duration-300">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->caption ?? 'Gallery Photo' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @if($gallery->caption)
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-955/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <p class="text-xs text-slate-200 leading-relaxed">{{ $gallery->caption }}</p>
                        </div>
                    @endif
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada foto di galeri. Silakan tambahkan lewat dashboard admin.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
