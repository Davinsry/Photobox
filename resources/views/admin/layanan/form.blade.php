@extends('layouts.admin')

@section('page_title', isset($package) ? 'Edit Paket Layanan' : 'Tambah Paket Baru')

@section('content')
<div class="max-w-2xl bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
    <div class="border-b border-slate-850 pb-4 mb-6">
        <h2 class="text-xl font-bold font-outfit text-white">{{ isset($package) ? 'Ubah Rincian Paket' : 'Rincian Paket Baru' }}</h2>
        <p class="text-xs text-slate-400 mt-1">Paket ini akan ditampilkan di form reservasi pelanggan jika diaktifkan.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-rose-500/10 border border-rose-500/35 text-rose-300 px-6 py-4 rounded-2xl text-sm">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($package) ? route('admin.layanan.update', $package->id) : route('admin.layanan.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($package))
            @method('PUT')
        @endif

        <div class="space-y-6 mb-8">
            <!-- Nama Paket -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Nama Paket</label>
                <input type="text" name="name" id="name" 
                       value="{{ old('name', $package->name ?? '') }}"
                       placeholder="Contoh: Basic Photobox, Premium Group"
                       required
                       class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Deskripsi Layanan</label>
                <textarea name="description" id="description" rows="4" 
                          placeholder="Tuliskan apa saja yang didapat pelanggan dari paket ini..."
                          class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors resize-none">{{ old('description', $package->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Harga -->
                <div>
                    <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Harga (Rupiah)</label>
                    <input type="number" name="price" id="price" 
                           value="{{ old('price', isset($package) ? (int)$package->price : '') }}"
                           placeholder="Contoh: 50000"
                           required
                           class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                </div>

                <!-- Durasi -->
                <div>
                    <label for="duration_minutes" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Durasi Sesi (Menit)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes" 
                           value="{{ old('duration_minutes', $package->duration_minutes ?? 15) }}"
                           placeholder="Contoh: 15"
                           required
                           class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
                </div>
            </div>

            <!-- Thumbnail Upload -->
            <div>
                <label for="thumbnail" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Foto / Thumbnail Paket</label>
                @if(isset($package) && $package->thumbnail)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $package->thumbnail) }}" alt="{{ $package->name }}" class="w-32 h-32 object-cover rounded-2xl border border-slate-800">
                        <span class="text-xs text-slate-500 mt-1 block">Foto saat ini. Unggah foto baru untuk mengganti.</span>
                    </div>
                @endif
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                       class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-indigo-400 hover:file:bg-slate-800">
                <span class="text-xxs text-slate-500 mt-1.5 block">Format: JPG, JPEG, PNG. Maks: 2MB.</span>
            </div>

            <!-- Is Active Toggle -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" 
                       {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-slate-800 text-indigo-500 focus:ring-indigo-500 bg-slate-950 w-5 h-5 cursor-pointer">
                <label for="is_active" class="ml-3 text-sm font-semibold text-slate-300 cursor-pointer select-none">Aktifkan Paket (Muncul di Landing Page)</label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 border-t border-slate-850 pt-6">
            <a href="{{ route('admin.layanan.index') }}" class="px-6 py-3.5 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-400 hover:text-white font-bold rounded-2xl text-xs transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl text-xs transition-colors shadow-lg shadow-indigo-500/20">
                {{ isset($package) ? 'Simpan Perubahan' : 'Buat Paket Layanan' }}
            </button>
        </div>
    </form>
</div>
@endsection
