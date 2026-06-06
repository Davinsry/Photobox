<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembayaran Berhasil</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .details { margin: 20px 0; }
        .details th { text-align: left; padding: 8px 0; }
        .details td { padding: 8px 0; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pembayaran Diterima</h2>
            <p>Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="content">
            <p>Halo {{ $booking->guest_name }},</p>
            <p>Pembayaran Anda untuk reservasi di Studioku Jogja telah berhasil dikonfirmasi! Jadwal sesi Anda telah **Lunas** dan siap digunakan.</p>
            
            <h3>Detail Reservasi:</h3>
            <table class="details" style="width: 100%;">
                <tr>
                    <th>Paket Layanan</th>
                    <td>{{ $booking->package->name }}</td>
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
                    <th>Metode Pembayaran</th>
                    <td>{{ $booking->payment->payment_method ?? 'Transfer' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Dibayar</th>
                    <td style="color: #10b981; font-weight: bold;">Rp {{ number_format($booking->payment->amount ?? $booking->package->price, 0, ',', '.') }}</td>
                </tr>
            </table>

            <p>Silakan datang ke studio 10 menit sebelum jadwal sesi dimulai. Tunjukkan email ini atau sebutkan kode booking Anda kepada petugas studio saat check-in.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Studioku Jogja. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
