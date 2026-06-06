<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Mail\ReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to customers with bookings scheduled for tomorrow (H-1)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        $bookings = Booking::with('package')
            ->where('booking_date', $tomorrow)
            ->whereIn('status', ['paid', 'pending'])
            ->get();

        $this->info('Found ' . $bookings->count() . ' bookings for tomorrow (' . $tomorrow . ').');

        foreach ($bookings as $booking) {
            try {
                Mail::to($booking->guest_email)->send(new ReminderMail($booking));
                $this->info('Reminder sent to ' . $booking->guest_email . ' for booking #' . $booking->booking_code);
            } catch (\Exception $e) {
                $this->error('Failed to send reminder to ' . $booking->guest_email . ': ' . $e->getMessage());
                Log::error('Reminder email failed: ' . $e->getMessage());
            }
        }

        $this->info('Finished sending reminders.');
    }
}
