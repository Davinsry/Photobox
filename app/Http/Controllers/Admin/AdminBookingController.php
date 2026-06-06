<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::all();
        
        $query = Booking::with(['package', 'payment']);

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Package
        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        $bookings = $query->orderBy('booking_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(15);

        return view('admin.booking.index', compact('bookings', 'packages'));
    }

    public function show($id)
    {
        $booking = Booking::with(['package', 'payment'])->findOrFail($id);
        return view('admin.booking.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::with('payment')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        // Sync payment status as well
        if ($booking->payment) {
            $paymentStatus = $request->status;
            if ($request->status == 'completed') {
                $paymentStatus = 'paid';
            }
            
            $booking->payment->update(['status' => $paymentStatus]);
        }

        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = Booking::with(['package', 'payment']);

        // Apply filters
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('package_id')) {
            $query->where('package_id', $request->package_id);
        }

        $bookings = $query->orderBy('booking_date', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=booking_report_" . date('Y-m-d') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Kode Booking', 'Nama Guest', 'Email', 'No HP', 'Paket', 'Tanggal Sesi', 'Jam Mulai', 'Jam Selesai', 'Status', 'Catatan', 'Total Bayar'];

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->booking_code,
                    $booking->guest_name,
                    $booking->guest_email,
                    $booking->guest_phone,
                    $booking->package->name,
                    $booking->booking_date,
                    $booking->start_time,
                    $booking->end_time,
                    $booking->status,
                    $booking->notes,
                    $booking->package->price,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
