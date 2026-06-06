<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengingat Sesi Foto Besok!</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .details { margin: 20px 0; }
        .details th { text-align: left; padding: 8px 0; }
        .details td { padding: 8px 0; text-align: right; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pengingat: Sesi Foto Besok!</h2>
            <p>Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="content">
            <p>Halo {{ $booking->guest_name }},</p>
            <p>Ini adalah pengingat ramah bahwa Anda memiliki jadwal sesi foto di **Studioku Jogja** besok!</p>
            
            <h3>Detail Jadwal Anda:</h3>
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
                    <td style="font-weight: bold; color: #3b82f6;">{{ $booking->start_time }} - {{ $booking->end_time }} WIB</td>
                </tr>
            </table>

            <p>Harap tiba di studio setidaknya 10 menit sebelum waktu sesi dimulai untuk persiapan pose atau kostum tambahan agar sesi dapat berjalan maksimal.</p>
            <p>Jika ada kendala atau pertanyaan, silakan hubungi kami.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Studioku Jogja. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
