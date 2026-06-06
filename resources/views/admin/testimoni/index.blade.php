@extends('layouts.admin')

@section('page_title', 'Kelola Testimoni Pelanggan')

@section('content')
<div class="space-y-6 max-w-6xl">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold font-outfit text-white">Daftar Testimoni</h2>
        <a href="{{ route('admin.testimoni.create') }}" class="px-5 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-xl text-xs transition-all shadow-lg shadow-indigo-500/25">
            + Tambah Testimoni Baru
        </a>
    </div>

    <!-- Testimonials List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($testimonials as $testimonial)
        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 flex flex-col hover:border-slate-700 transition-all relative group shadow-lg">
            <!-- Visibility Badge -->
            <div class="absolute top-4 right-4">
                @if($testimonial->is_visible)
                    <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Ditampilkan</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xxs font-bold bg-slate-800 text-slate-400 border border-slate-700">Disembunyikan</span>
                @endif
            </div>

            <!-- Rating Stars -->
            <div class="flex items-center space-x-1 mb-4 pt-2">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-700' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                @endfor
            </div>

            <!-- Content -->
            <p class="text-sm text-slate-300 mb-6 flex-grow italic leading-relaxed">
                "{{ $testimonial->content }}"
            </p>

            <!-- User Info -->
            <div class="flex justify-between items-center border-t border-slate-850 pt-4 mt-auto">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-full bg-indigo-500/15 flex items-center justify-center font-bold text-xs text-indigo-400">
                        {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-white leading-normal">{{ $testimonial->customer_name }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-2">
                    <a href="{{ route('admin.testimoni.edit', $testimonial->id) }}" class="p-2 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-400 hover:text-white rounded-xl text-xs transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </a>
                    <form action="{{ route('admin.testimoni.destroy', $testimonial->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-rose-500/10 hover:bg-rose-500 border border-rose-500/20 text-rose-400 hover:text-white rounded-xl text-xs transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 bg-slate-900 border border-slate-800 rounded-3xl">
            <p class="text-slate-400 text-sm">Belum ada testimoni. Silakan tambah testimoni baru.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
