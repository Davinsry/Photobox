<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminJadwalController extends Controller
{
    public function index()
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

        return view('admin.jadwal.index', compact('blockedSchedules', 'openingTime', 'closingTime'));
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
