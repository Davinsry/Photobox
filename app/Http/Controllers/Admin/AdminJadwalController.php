<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminJadwalController extends Controller
{
    public function index(Request $request)
    {
        $blockedSchedules = BlockedSchedule::orderBy('blocked_date', 'desc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Load studio settings
        $settingsPath = storage_path('app/settings.json');
        $settings = [];
        if (File::exists($settingsPath)) {
            $settings = json_decode(File::get($settingsPath), true);
        }

        $openingTime = $settings['opening_time'] ?? '09:00';
        $closingTime = $settings['closing_time'] ?? '21:00';

        if (!preg_match('/^\d{2}:\d{2}$/', $openingTime)) {
            $openingTime = '09:00';
        }
        if (!preg_match('/^\d{2}:\d{2}$/', $closingTime)) {
            $closingTime = '21:00';
        }

        // Get selected date (default to today)
        $selectedDate = $request->get('date');
        if (!$selectedDate || strtotime($selectedDate) === false) {
            $selectedDate = Carbon::today('Asia/Jakarta')->toDateString();
        }

        // Generate Time Slots based on studio hours and standard 30 minutes duration
        $duration = 30;
        $slots = [];

        try {
            $start = Carbon::parse($selectedDate . ' ' . $openingTime, 'Asia/Jakarta');
            $end = Carbon::parse($selectedDate . ' ' . $closingTime, 'Asia/Jakarta');
        } catch (\Exception $e) {
            $start = Carbon::parse($selectedDate . ' 09:00', 'Asia/Jakarta');
            $end = Carbon::parse($selectedDate . ' 21:00', 'Asia/Jakarta');
        }

        // Fetch bookings and blocks for the selected date
        $bookings = \App\Models\Booking::where('booking_date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->get();

        $blocks = BlockedSchedule::where('blocked_date', $selectedDate)->get();

        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slotStartStr = $start->toTimeString();
            $slotEndStr = $start->copy()->addMinutes($duration)->toTimeString();
            
            $status = 'available'; // available, booked, blocked, past
            $info = '';

            // Check if slot starts in the past (if date is today)
            if (Carbon::parse($selectedDate, 'Asia/Jakarta')->isToday() && $start->isBefore(Carbon::now('Asia/Jakarta'))) {
                $status = 'past';
                $info = 'Sudah Lewat';
            }

            // Check Booking Overlap
            if ($status === 'available' || $status === 'past') {
                foreach ($bookings as $booking) {
                    if ($slotStartStr < $booking->end_time && $slotEndStr > $booking->start_time) {
                        $status = 'booked';
                        $info = 'Pesan: ' . $booking->guest_name;
                        break;
                    }
                }
            }

            // Check Blocked Schedule Overlap
            if ($status === 'available' || $status === 'past') {
                foreach ($blocks as $block) {
                    if (is_null($block->start_time) && is_null($block->end_time)) {
                        $status = 'blocked';
                        $info = 'Libur: ' . ($block->reason ?? 'Maintenance');
                        break;
                    } elseif ($slotStartStr < $block->end_time && $slotEndStr > $block->start_time) {
                        $status = 'blocked';
                        $info = 'Blokir: ' . ($block->reason ?? 'Maintenance');
                        break;
                    }
                }
            }

            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $start->copy()->addMinutes($duration)->format('H:i'),
                'status' => $status,
                'info' => $info
            ];

            $start->addMinutes($duration);
        }

        return view('admin.jadwal.index', compact('blockedSchedules', 'openingTime', 'closingTime', 'selectedDate', 'slots'));
    }

    public function storeBlock(Request $request)
    {
        $request->validate([
            'blocked_date' => 'required|date',
            'start_time' => 'nullable|required_with:end_time',
            'end_time' => 'nullable|required_with:start_time|after:start_time',
            'reason' => 'nullable|string|max:255',
            'is_full_day' => 'nullable|boolean',
        ]);

        $isFullDay = $request->has('is_full_day');

        BlockedSchedule::create([
            'blocked_date' => $request->blocked_date,
            'start_time' => $isFullDay ? null : $request->start_time,
            'end_time' => $isFullDay ? null : $request->end_time,
            'reason' => $request->reason ?: 'Libur / Maintenance',
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diblokir.');
    }

    public function destroyBlock($id)
    {
        $block = BlockedSchedule::findOrFail($id);
        $block->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Blokir jadwal berhasil dihapus.');
    }

    public function saveSettings(Request $request)
    {
        $request->validate([
            'opening_time' => 'required|string',
            'closing_time' => 'required|string|after:opening_time',
        ]);

        $settingsPath = storage_path('app/settings.json');
        
        $settings = [
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
        ];

        // Ensure parent directory exists
        $dir = dirname($settingsPath);
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        File::put($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));

        return redirect()->route('admin.jadwal.index')->with('success', 'Pengaturan jam operasional berhasil disimpan.');
    }
}
