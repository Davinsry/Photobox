<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Package::where('is_active', true)->get();
        return view('welcome', compact('packages'));
    }
}
