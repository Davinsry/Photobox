<?php

namespace Tests\Feature;

use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingWizardTest extends TestCase
{
    use RefreshDatabase;

    protected $package;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a dummy package for booking tests
        $this->package = Package::create([
            'name' => 'Test Package',
            'slug' => 'test-package',
            'description' => 'Test description',
            'price' => 100000,
            'duration_minutes' => 30,
            'is_active' => true,
        ]);
    }

    public function test_slots_before_30_minutes_from_now_are_unavailable()
    {
        // Mock current time to 2026-06-13 12:00:00
        $mockNow = Carbon::parse('2026-06-13 12:00:00', 'Asia/Jakarta');
        Carbon::setTestNow($mockNow);

        // Put package in session
        $sessionData = ['package_id' => $this->package->id];
        
        $response = $this->withSession(['booking_wizard' => $sessionData])
            ->get(route('booking.step2', ['date' => '2026-06-13']));

        $response->assertStatus(200);

        // Verify that the view variables contain slots, and slots before 12:30 are unavailable
        $slots = $response->viewData('slots');
        $this->assertNotEmpty($slots);

        foreach ($slots as $slot) {
            $slotStart = Carbon::parse('2026-06-13 ' . $slot['start'], 'Asia/Jakarta');
            
            if ($slotStart->isBefore($mockNow->copy()->addMinutes(30))) {
                $this->assertFalse($slot['is_available'], "Slot starting at {$slot['start']} should be unavailable.");
                $this->assertEquals('Terlalu Dekat (Min. 30 Menit)', $slot['reason']);
            } else {
                // If it's not blocked by other logic, it should be available
                $this->assertTrue($slot['is_available'], "Slot starting at {$slot['start']} should be available.");
            }
        }

        // Clean up
        Carbon::setTestNow();
    }

    public function test_cannot_submit_slot_less_than_30_minutes_from_now()
    {
        // Mock current time to 2026-06-13 12:00:00
        $mockNow = Carbon::parse('2026-06-13 12:00:00', 'Asia/Jakarta');
        Carbon::setTestNow($mockNow);

        $sessionData = ['package_id' => $this->package->id];

        // Submit a slot starting at 12:00 (which is less than 30 minutes from now)
        $response = $this->withSession(['booking_wizard' => $sessionData])
            ->post(route('booking.step2'), [
                'date' => '2026-06-13',
                'slot' => '12:00-12:30',
            ]);

        $response->assertSessionHasErrors('slot');

        // Submit a slot starting at 12:30 (which is exactly 30 minutes from now, so it should be allowed)
        $response2 = $this->withSession(['booking_wizard' => $sessionData])
            ->post(route('booking.step2'), [
                'date' => '2026-06-13',
                'slot' => '12:30-13:00',
            ]);

        $response2->assertSessionHasNoErrors();
        $response2->assertRedirect(route('booking.step3'));

        // Clean up
        Carbon::setTestNow();
    }
}
