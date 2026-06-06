<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create($package_id)
    {
        $package = Package::findOrFail($package_id);
        return view('booking.create', compact('package'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
        ]);

        $package = Package::findOrFail($request->package_id);
        
        // Cek ketersediaan slot
        $exists = Booking::where('booking_date', $request->booking_date)
            ->where('booking_time', $request->booking_time)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['booking_time' => 'Maaf, slot waktu ini sudah dipesan. Silakan pilih waktu lain.']);
        }

        $booking = Booking::create([
            'booking_code' => 'SB-' . strtoupper(Str::random(6)),
            'package_id' => $package->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'status' => 'pending',
            'total_amount' => $package->price,
        ]);

        return redirect()->route('booking.success', $booking->booking_code);
    }

    public function success($code)
    {
        $booking = Booking::with('package')->where('booking_code', $code)->firstOrFail();
        return view('booking.success', compact('booking'));
    }
}
