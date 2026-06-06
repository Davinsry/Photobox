<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('order', 'asc')->get();
        return view('admin.galeri.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Format JPG/PNG, max 2MB
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            
            // Auto order logic if empty
            $order = $request->input('order');
            if (is_null($order)) {
                $maxOrder = Gallery::max('order');
                $order = $maxOrder ? $maxOrder + 1 : 1;
            }

            Gallery::create([
                'image_path' => $path,
                'caption' => $request->caption,
                'order' => $order,
            ]);

            return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah foto.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Foto galeri berhasil dihapus.');
    }
}
