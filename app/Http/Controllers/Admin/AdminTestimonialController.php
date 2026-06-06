<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimoni.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimoni.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'is_visible' => 'nullable|boolean',
        ]);

        Testimonial::create([
            'customer_name' => $request->customer_name,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimoni.form', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'is_visible' => 'nullable|boolean',
        ]);

        $testimonial->update([
            'customer_name' => $request->customer_name,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_visible' => $request->has('is_visible'),
        ]);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni berhasil dihapus.');
    }
}
