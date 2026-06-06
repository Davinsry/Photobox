<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notifikasi Booking Baru</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .details { margin: 20px 0; }
        .details th { text-align: left; padding: 8px 0; }
        .details td { padding: 8px 0; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pemberitahuan Reservasi Baru</h2>
            <p>Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="content">
            <p>Halo Admin,</p>
            <p>Ada pemesanan reservasi baru masuk ke sistem Studioku Jogja.</p>
            
            <h3>Data Pemesan & Sesi:</h3>
            <table class="details" style="width: 100%;">
                <tr>
                    <th>Nama Guest</th>
                    <td>{{ $booking->guest_name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $booking->guest_email }}</td>
                </tr>
                <tr>
                    <th>Nomor HP</th>
                    <td>{{ $booking->guest_phone }}</td>
                </tr>
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
                    <th>Catatan</th>
                    <td>{{ $booking->notes ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status Pembayaran</th>
                    <td><strong>{{ strtoupper($booking->status) }}</strong></td>
                </tr>
            </table>

            <p>Silakan kelola data booking ini melalui dashboard admin Anda.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Studioku Jogja. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
