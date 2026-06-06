<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.layanan.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.layanan.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'duration_minutes']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('packages', 'public');
            $data['thumbnail'] = $path;
        }

        Package::create($data);

        return redirect()->route('admin.layanan.index')->with('success', 'Paket layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.layanan.form', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'duration_minutes']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($package->thumbnail) {
                Storage::disk('public')->delete($package->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('packages', 'public');
            $data['thumbnail'] = $path;
        }

        $package->update($data);

        return redirect()->route('admin.layanan.index')->with('success', 'Paket layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        
        if ($package->thumbnail) {
            Storage::disk('public')->delete($package->thumbnail);
        }

        $package->delete();

        return redirect()->route('admin.layanan.index')->with('success', 'Paket layanan berhasil dihapus.');
    }
}
