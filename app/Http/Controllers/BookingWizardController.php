<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use App\Models\BlockedSchedule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingWizardController extends Controller
{
    // Step 1: Pilih Paket
    public function step1(Request $request)
    {
        $packages = Package::where('is_active', true)->get();
        
        // Clear previous booking session if starting fresh
        if (!$request->has('package_id')) {
            session()->forget('booking_wizard');
        } else {
            $sessionData = session()->get('booking_wizard', []);
            $sessionData['package_id'] = $request->package_id;
            session()->put('booking_wizard', $sessionData);
            return redirect()->route('booking.step2');
        }

        return view('booking.step1', compact('packages'));
    }

    // Step 2: Pilih Tanggal & Waktu
    public function step2(Request $request)
    {
        $sessionData = session()->get('booking_wizard', []);
        
        // Ensure package is selected
        if (!isset($sessionData['package_id'])) {
            return redirect()->route('booking.step1')->with('error', 'Silakan pilih paket terlebih dahulu.');
        }

        $package = Package::findOrFail($sessionData['package_id']);
        
        // Default to today or selected date
        $selectedDate = $request->get('date');
        if (!$selectedDate || strtotime($selectedDate) === false) {
            $selectedDate = Carbon::today()->toDateString();
        } else {
            try {
                $parsedDate = Carbon::parse($selectedDate);
                if ($parsedDate->isPast() && !$parsedDate->isToday()) {
                    $selectedDate = Carbon::today()->toDateString();
                } else {
                    $selectedDate = $parsedDate->toDateString();
                }
            } catch (\Exception $e) {
                $selectedDate = Carbon::today()->toDateString();
            }
        }

        // Generate Time Slots based on studio hours and package duration
        $settingsPath = storage_path('app/settings.json');
        $settings = [];
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
        }
        $openingTime = $settings['opening_time'] ?? '09:00';
        $closingTime = $settings['closing_time'] ?? '21:00';
        
        if (!preg_match('/^\d{2}:\d{2}$/', $openingTime)) {
            $openingTime = '09:00';
        }
        if (!preg_match('/^\d{2}:\d{2}$/', $closingTime)) {
            $closingTime = '21:00';
        }
        
        $slots = [];
        $duration = $package->duration_minutes ?: 30;
        if ($duration <= 0) {
            $duration = 30;
        }

        try {
            $start = Carbon::parse($selectedDate . ' ' . $openingTime);
            $end = Carbon::parse($selectedDate . ' ' . $closingTime);
        } catch (\Exception $e) {
            $start = Carbon::parse($selectedDate . ' 09:00');
            $end = Carbon::parse($selectedDate . ' 21:00');
        }

        // Fetch bookings and blocks for the selected date
        $bookings = Booking::where('booking_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->get();

        $blocks = BlockedSchedule::where('blocked_date', $selectedDate)->get();

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotStartStr = $start->toTimeString();
            $slotEndStr = $start->copy()->addMinutes($duration)->toTimeString();
            
            $isAvailable = true;
            $statusReason = '';

            // Check if slot starts in the past (if date is today)
            if (Carbon::parse($selectedDate)->isToday() && $start->isBefore(Carbon::now())) {
                $isAvailable = false;
                $statusReason = 'Past Time';
            }

            // Check Booking Overlap
            if ($isAvailable) {
                foreach ($bookings as $booking) {
                    if ($slotStartStr < $booking->end_time && $slotEndStr > $booking->start_time) {
                        $isAvailable = false;
                        $statusReason = 'Terisi (Booked)';
                        break;
                    }
                }
            }

            // Check Blocked Schedule Overlap
            if ($isAvailable) {
                foreach ($blocks as $block) {
                    if (is_null($block->start_time) && is_null($block->end_time)) {
                        // Full day block
                        $isAvailable = false;
                        $statusReason = 'Libur: ' . ($block->reason ?? 'Maintenance');
                        break;
                    } elseif ($slotStartStr < $block->end_time && $slotEndStr > $block->start_time) {
                        // Partial block
                        $isAvailable = false;
                        $statusReason = 'Diblokir: ' . ($block->reason ?? 'Maintenance');
                        break;
                    }
                }
            }

            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $start->copy()->addMinutes($duration)->format('H:i'),
                'is_available' => $isAvailable,
                'reason' => $statusReason
            ];

            // Increment slot
            $start->addMinutes($duration);
        }

        // Handle Form Submission
        if ($request->isMethod('post') || $request->has('slot')) {
            $request->validate([
                'date' => 'required|date|after_or_equal:today',
                'slot' => 'required|string',
            ]);

            list($slotStart, $slotEnd) = explode('-', $request->slot);

            $sessionData['booking_date'] = $request->date;
            $sessionData['start_time'] = $slotStart;
            $sessionData['end_time'] = $slotEnd;

            session()->put('booking_wizard', $sessionData);
            return redirect()->route('booking.step3');
        }

        return view('booking.step2', compact('package', 'selectedDate', 'slots'));
    }

    // Step 3: Isi Data Diri
    public function step3(Request $request)
    {
        $sessionData = session()->get('booking_wizard', []);
        
        if (!isset($sessionData['package_id']) || !isset($sessionData['booking_date'])) {
            return redirect()->route('booking.step1');
        }

        $package = Package::findOrFail($sessionData['package_id']);

        if ($request->isMethod('post') || $request->has('guest_name')) {
            $request->validate([
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|email|max:255',
                'guest_phone' => 'required|string|max:20',
                'notes' => 'nullable|string|max:1000',
            ]);

            $sessionData['guest_name'] = $request->guest_name;
            $sessionData['guest_email'] = $request->guest_email;
            $sessionData['guest_phone'] = $request->guest_phone;
            $sessionData['notes'] = $request->notes;

            session()->put('booking_wizard', $sessionData);
            return redirect()->route('booking.step4');
        }

        return view('booking.step3', compact('package', 'sessionData'));
    }

    // Step 4: Ringkasan & Konfirmasi
    public function step4()
    {
        $sessionData = session()->get('booking_wizard', []);
        
        if (!isset($sessionData['guest_name'])) {
            return redirect()->route('booking.step3');
        }

        $package = Package::findOrFail($sessionData['package_id']);
        
        return view('booking.step4', compact('package', 'sessionData'));
    }

    // Simpan Booking & Redirect ke Payment
    public function store(Request $request)
    {
        $sessionData = session()->get('booking_wizard', []);
        
        if (!isset($sessionData['guest_name'])) {
            return redirect()->route('booking.step1');
        }

        $package = Package::findOrFail($sessionData['package_id']);

        // Check availability one more time to avoid double booking
        $overlap = Booking::where('booking_date', $sessionData['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where('start_time', '<', $sessionData['end_time'])
            ->where('end_time', '>', $sessionData['start_time'])
            ->exists();

        if ($overlap) {
            return redirect()->route('booking.step2')->withErrors(['slot' => 'Maaf, slot waktu ini baru saja dipesan oleh orang lain. Silakan pilih slot lain.']);
        }

        // Generate Unique Booking Code
        $bookingCode = 'SB-' . strtoupper(Str::random(6));

        // Create Booking
        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'package_id' => $package->id,
            'guest_name' => $sessionData['guest_name'],
            'guest_email' => $sessionData['guest_email'],
            'guest_phone' => $sessionData['guest_phone'],
            'booking_date' => $sessionData['booking_date'],
            'start_time' => $sessionData['start_time'],
            'end_time' => $sessionData['end_time'],
            'status' => 'pending',
            'notes' => $sessionData['notes'] ?? null,
        ]);

        // Create initial Payment transaction
        $booking->payment()->create([
            'amount' => $package->price,
            'status' => 'pending',
        ]);

        // Send confirmation emails
        try {
            \Illuminate\Support\Facades\Mail::to($booking->guest_email)->send(new \App\Mail\BookingConfirmationMail($booking));
            \Illuminate\Support\Facades\Mail::to('admin@studioku.com')->send(new \App\Mail\AdminNotificationMail($booking));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send booking confirmation emails: ' . $e->getMessage());
        }

        // Clear wizard session
        session()->forget('booking_wizard');

        // Trigger Midtrans or payment simulation redirect
        // For development, redirect to success page and allow manual payment simulation there
        return redirect()->route('booking.sukses', ['code' => $booking->booking_code]);
    }

    // Halaman sukses + detail booking
    public function sukses(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('booking.cek.form')->with('error', 'Silakan masukkan kode booking untuk melihat status pembayaran.');
        }

        $booking = Booking::with(['package', 'payment'])->where('booking_code', $code)->first();
        if (!$booking) {
            return redirect()->route('booking.cek.form')->with('error', 'Kode booking tidak ditemukan.');
        }
        
        return view('booking.success', compact('booking'));
    }

    // Form cek status booking
    public function checkStatusForm()
    {
        return view('booking.status');
    }

    // Tampilkan hasil cek status
    public function checkStatus(Request $request)
    {
        $request->validate([
            'booking_code' => 'required|string',
            'guest_email' => 'required|email',
        ]);

        $booking = Booking::with(['package', 'payment'])
            ->where('booking_code', $request->booking_code)
            ->where('guest_email', $request->guest_email)
            ->first();

        if (!$booking) {
            return back()->withInput()->withErrors(['booking_code' => 'Data booking tidak ditemukan. Silakan periksa kembali kode booking dan email Anda.']);
        }

        return view('booking.status', compact('booking'));
    }
}
