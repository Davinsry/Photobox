<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Konfirmasi Booking</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #6366f1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .details { margin: 20px 0; }
        .details th { text-align: left; padding: 8px 0; }
        .details td { padding: 8px 0; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Reservasi Anda Berhasil Dibuat</h2>
            <p>Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="content">
            <p>Halo {{ $booking->guest_name }},</p>
            <p>Terima kasih telah melakukan pemesanan di Studioku Jogja. Reservasi Anda saat ini berstatus <strong>Menunggu Pembayaran</strong>.</p>
            
            <h3>Detail Reservasi:</h3>
            <table class="details" style="width: 100%;">
                <tr>
                    <th>Paket Layanan</th>
                    <td>{{ $booking->package->name }}</td>
                </tr>
                <tr>
                    <th>Durasi Sesi</th>
                    <td>{{ $booking->package->duration_minutes }} Menit</td>
                </tr>
                <tr>
                    <th>Tanggal Sesi</th>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <th>Jam Sesi</th>
                    <td>{{ $booking->start_time }} - {{ $booking->end_time }} WIB</td>
                </tr>
                <tr>
                    <th>Total Biaya</th>
                    <td style="color: #6366f1; font-weight: bold;">Rp {{ number_format($booking->package->price, 0, ',', '.') }}</td>
                </tr>
            </table>

            <p>Silakan lakukan pembayaran agar jadwal sesi Anda tidak dibatalkan otomatis oleh sistem.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Studioku Jogja. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
