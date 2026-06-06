<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Gallery;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->take(3)->get();
        $galleries = Gallery::orderBy('order', 'asc')->take(6)->get();
        $testimonials = Testimonial::where('is_visible', true)->take(6)->get();
        
        return view('welcome', compact('packages', 'galleries', 'testimonials'));
    }

    public function layanan()
    {
        $packages = Package::where('is_active', true)->get();
        return view('layanan', compact('packages'));
    }

    public function galeri()
    {
        $galleries = Gallery::orderBy('order', 'asc')->get();
        return view('galeri', compact('galleries'));
    }

    public function testimoni()
    {
        $testimonials = Testimonial::where('is_visible', true)->get();
        return view('testimoni', compact('testimonials'));
    }
}
