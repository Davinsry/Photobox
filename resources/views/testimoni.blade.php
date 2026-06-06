@extends('layouts.main')

@section('title', 'Testimoni')

@section('content')
    <section class="py-16 relative">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] opacity-10 bg-indigo-500 blur-[100px] rounded-full mix-blend-screen pointer-events-none"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Ulasan Pengunjung</h1>
                <p class="text-lg text-slate-400">Kepuasan Anda adalah prioritas kami. Baca ulasan jujur dari pelanggan kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 hover:border-indigo-500/30 transition-all">
                    <!-- Stars -->
                    <div class="flex items-center space-x-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        @endfor
                    </div>
                    
                    <p class="text-slate-300 leading-relaxed mb-6 italic">"{{ $testimonial->content }}"</p>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-500/25 flex items-center justify-center font-bold text-indigo-400">
                            {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-white">{{ $testimonial->customer_name }}</h4>
                            <p class="text-xs text-slate-500">Verified Customer</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-400 text-lg">Belum ada testimoni.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
