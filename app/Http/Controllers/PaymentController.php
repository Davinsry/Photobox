<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;
use App\Mail\AdminNotificationMail;
use Carbon\Carbon;

class PaymentController extends Controller
{
    /**
     * Generate Midtrans Snap token for a booking.
     * In a production setup, this would be loaded on the checkout page.
     */
    public function getSnapToken(Booking $booking)
    {
        $serverKey = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production', false);
        
        $url = $isProduction 
            ? 'https://app.midtrans.com/snap/v1/transactions' 
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
            ])->post($url, [
                'transaction_details' => [
                    'order_id' => $booking->booking_code,
                    'gross_amount' => (int) $booking->package->price,
                ],
                'customer_details' => [
                    'first_name' => $booking->guest_name,
                    'email' => $booking->guest_email,
                    'phone' => $booking->guest_phone,
                ],
                'item_details' => [
                    [
                        'id' => $booking->package_id,
                        'price' => (int) $booking->package->price,
                        'quantity' => 1,
                        'name' => $booking->package->name,
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Midtrans token generation failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans API connection error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Local Simulation of payment for development and verification.
     */
    public function simulatePayment(Request $request, $code)
    {
        $status = $request->input('simulate_status', 'paid'); // 'paid' or 'cancelled'
        
        $booking = Booking::with(['package', 'payment'])->where('booking_code', $code)->firstOrFail();

        if ($status == 'paid') {
            $booking->update(['status' => 'paid']);
            
            if ($booking->payment) {
                $paymentMethod = $booking->payment->payment_method ? strtoupper($booking->payment->payment_method) : 'QRIS';
                $booking->payment->update([
                    'status' => 'paid',
                    'payment_method' => $paymentMethod . ' (Simulated)',
                    'transaction_id' => 'SIM-TX-' . strtoupper(str_replace('.', '', uniqid('', true))),
                    'paid_at' => Carbon::now(),
                ]);
            }

            // Send Confirmation Email
            try {
                Mail::to($booking->guest_email)->send(new PaymentSuccessMail($booking));
                Mail::to('admin@studioku.com')->send(new AdminNotificationMail($booking));
            } catch (\Exception $e) {
                Log::error('Failed to send mail in simulation: ' . $e->getMessage());
            }

            return redirect()->route('booking.sukses', ['code' => $booking->booking_code])
                ->with('success', 'Simulasi Pembayaran Berhasil! Status diubah menjadi Lunas.');
        } else {
            $booking->update(['status' => 'cancelled']);
            
            if ($booking->payment) {
                $booking->payment->update(['status' => 'cancelled']);
            }

            return redirect()->route('booking.sukses', ['code' => $booking->booking_code])
                ->with('error', 'Simulasi Pembayaran Dibatalkan.');
        }
    }

    /**
     * Midtrans Notification / Webhook handler.
     */
    public function notification(Request $request)
    {
        $payload = $request->all();
        Log::info('Midtrans Webhook Payload: ', $payload);

        $serverKey = config('services.midtrans.server_key');
        
        // Calculate signature hash to verify authenticity
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signatureKey !== $calculatedSignature) {
            Log::warning('Midtrans signature key invalid!');
            return response()->json(['message' => 'Invalid Signature'], 400);
        }

        $booking = Booking::with('payment')->where('booking_code', $orderId)->first();
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $transactionStatus = $payload['transaction_status'];
        $paymentType = $payload['payment_type'] ?? 'unknown';
        $transactionId = $payload['transaction_id'] ?? '';

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            $booking->update(['status' => 'paid']);
            if ($booking->payment) {
                $booking->payment->update([
                    'status' => 'paid',
                    'payment_method' => $paymentType,
                    'transaction_id' => $transactionId,
                    'paid_at' => Carbon::now(),
                ]);
            }
            
            // Send Payment Success Email
            try {
                Mail::to($booking->guest_email)->send(new PaymentSuccessMail($booking));
                Mail::to('admin@studioku.com')->send(new AdminNotificationMail($booking));
            } catch (\Exception $e) {
                Log::error('Webhook email sending error: ' . $e->getMessage());
            }

        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
            $booking->update(['status' => 'cancelled']);
            if ($booking->payment) {
                $booking->payment->update([
                    'status' => 'cancelled',
                    'payment_method' => $paymentType,
                    'transaction_id' => $transactionId,
                ]);
            }
        }

        return response()->json(['message' => 'Success']);
    }

    /**
     * Frontend redirect target from Midtrans payment flow.
     */
    public function callback(Request $request)
    {
        $code = $request->query('order_id');
        $status = $request->query('status_code');
        
        $booking = Booking::where('booking_code', $code)->first();

        if ($booking) {
            return redirect()->route('booking.sukses', ['code' => $booking->booking_code]);
        }

        return redirect()->route('home');
    }
}
