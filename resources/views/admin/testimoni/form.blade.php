@extends('layouts.admin')

@section('page_title', isset($testimonial) ? 'Edit Testimoni' : 'Tambah Testimoni Baru')

@section('content')
<div class="max-w-2xl bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-xl">
    <div class="border-b border-slate-850 pb-4 mb-6">
        <h2 class="text-xl font-bold font-outfit text-white">{{ isset($testimonial) ? 'Ubah Testimoni Pelanggan' : 'Data Testimoni Baru' }}</h2>
        <p class="text-xs text-slate-400 mt-1">Ulasan ini dikelola secara manual dan akan ditampilkan di landing page jika dipilih untuk ditampilkan.</p>
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

    <form action="{{ isset($testimonial) ? route('admin.testimoni.update', $testimonial->id) : route('admin.testimoni.store') }}" 
          method="POST">
        @csrf
        @if(isset($testimonial))
            @method('PUT')
        @endif

        <div class="space-y-6 mb-8">
            <!-- Nama Customer -->
            <div>
                <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Nama Pelanggan</label>
                <input type="text" name="customer_name" id="customer_name" 
                       value="{{ old('customer_name', $testimonial->customer_name ?? '') }}"
                       placeholder="Contoh: Davin Sry"
                       required
                       class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors">
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Isi Testimoni / Ulasan</label>
                <textarea name="content" id="content" rows="4" 
                          placeholder="Tuliskan ulasan pelanggan di sini..."
                          required
                          class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors resize-none">{{ old('content', $testimonial->content ?? '') }}</textarea>
            </div>

            <!-- Rating -->
            <div>
                <label for="rating" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 font-mono">Rating (1 - 5 Bintang)</label>
                <select name="rating" id="rating" required
                        class="w-full bg-slate-950 border border-slate-800 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-indigo-500 transition-colors cursor-pointer appearance-none">
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ old('rating', $testimonial->rating ?? 5) == $i ? 'selected' : '' }}>
                            {{ $i }} Bintang {{ $i == 5 ? '(Sangat Puas)' : '' }}
                        </option>
                    @endfor
                </select>
            </div>

            <!-- Is Visible Toggle -->
            <div class="flex items-center">
                <input type="checkbox" name="is_visible" id="is_visible" value="1" 
                       {{ old('is_visible', $testimonial->is_visible ?? true) ? 'checked' : '' }}
                       class="rounded border-slate-800 text-indigo-500 focus:ring-indigo-500 bg-slate-950 w-5 h-5 cursor-pointer">
                <label for="is_visible" class="ml-3 text-sm font-semibold text-slate-300 cursor-pointer select-none">Tampilkan di Landing Page</label>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4 border-t border-slate-850 pt-6">
            <a href="{{ route('admin.testimoni.index') }}" class="px-6 py-3.5 bg-slate-950 border border-slate-850 hover:border-slate-700 text-slate-400 hover:text-white font-bold rounded-2xl text-xs transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-3.5 bg-indigo-500 hover:bg-indigo-600 text-white font-bold rounded-2xl text-xs transition-colors shadow-lg shadow-indigo-500/20">
                {{ isset($testimonial) ? 'Simpan Perubahan' : 'Buat Testimoni' }}
            </button>
        </div>
    </form>
</div>
@endsection
