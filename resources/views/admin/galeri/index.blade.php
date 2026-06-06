@extends('layouts.admin')

@section('page_title', 'Kelola Galeri Foto')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl">
    <!-- Upload Form -->
    <div class="lg:col-span-1 bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-lg h-fit">
        <div class="border-b border-slate-850 pb-4 mb-6">
            <h3 class="text-lg font-bold font-outfit text-white">Unggah Foto Baru</h3>
            <p class="text-xs text-slate-400 mt-1">Tambahkan portofolio atau sesi foto photobox terpopuler ke landing page.</p>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-4 py-3 rounded-2xl text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-5">
                <!-- File Input -->
                <div>
                    <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Pilih File Foto</label>
                    <input type="file" name="image" id="image" accept="image/*" required
                           class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-4 py-3.5 text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-indigo-400">
                    <span class="text-xxs text-slate-500 mt-1 block">Format: JPG, JPEG, PNG. Maks: 2MB.</span>
                </div>

                <!-- Caption -->
                <div>
                    <label for="caption" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Keterangan / Caption</label>
                    <input type="text" name="caption" id="caption" 
                           placeholder="Contoh: Graduation sesi fun bersama..."
                           class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors text-xs">
                </div>

                <!-- Order -->
                <div>
                    <label for="order" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Urutan Tampilan</label>
                    <input type="number" name="order" id="order" 
                           placeholder="Contoh: 1, 2, 3..."
                           class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors text-xs">
                    <span class="text-xxs text-slate-500 mt-1 block">Angka lebih kecil tampil di urutan teratas.</span>
                </div>

                <button type="submit" class="w-full py-3.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl text-xs transition-colors shadow-lg shadow-indigo-500/20">
                    Unggah Ke Galeri
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    <div class="lg:col-span-2 space-y-6">
        <h3 class="text-lg font-bold font-outfit text-white">Foto Galeri Saat Ini</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @forelse($galleries as $gallery)
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-lg group relative flex flex-col">
                <div class="relative aspect-[4/3] bg-slate-950">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Gallery Image" class="w-full h-full object-cover">
                    
                    <!-- Delete Button Overlay -->
                    <form action="{{ route('admin.galeri.destroy', $gallery->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri?')"
                          class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-8 h-8 rounded-xl bg-rose-500 hover:bg-rose-600 text-white flex items-center justify-center shadow-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>

                    <!-- Order Badge -->
                    <div class="absolute bottom-3 left-3 bg-slate-950/80 backdrop-blur px-2.5 py-1 rounded-lg border border-slate-800 text-xxs font-bold text-indigo-400 font-mono">
                        Urutan: #{{ $gallery->order }}
                    </div>
                </div>
                
                <div class="p-4 flex-grow flex items-center">
                    <p class="text-xs text-slate-300 italic leading-relaxed">
                        {{ $gallery->caption ?: 'Tidak ada keterangan caption.' }}
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16 bg-slate-900 border border-slate-800 rounded-3xl">
                <p class="text-slate-400 text-sm">Galeri kosong. Silakan unggah foto baru menggunakan form di samping.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
