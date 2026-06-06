<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Statistics
        $bookingsToday = Booking::whereDate('booking_date', $today)->count();
        $bookingsThisMonth = Booking::whereMonth('booking_date', $thisMonth)
            ->whereYear('booking_date', $thisYear)
            ->count();

        // Calculate revenue (only count paid or completed bookings)
        $revenueThisMonth = Booking::whereIn('status', ['paid', 'completed'])
            ->whereMonth('booking_date', $thisMonth)
            ->whereYear('booking_date', $thisYear)
            ->get()
            ->sum(function ($booking) {
                return $booking->package->price;
            });

        // Bookings by status
        $statusCounts = Booking::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $statusSummary = [
            'pending' => $statusCounts['pending'] ?? 0,
            'paid' => $statusCounts['paid'] ?? 0,
            'completed' => $statusCounts['completed'] ?? 0,
            'cancelled' => $statusCounts['cancelled'] ?? 0,
        ];

        // Recent bookings
        $recentBookings = Booking::with('package')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'bookingsToday',
            'bookingsThisMonth',
            'revenueThisMonth',
            'statusSummary',
            'recentBookings'
        ));
    }
}
