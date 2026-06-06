<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Success | Studioku Jogja</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; } h1,h2,h3 { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-slate-800 border border-slate-700 rounded-3xl p-8 md:p-12 text-center shadow-2xl relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-400 to-indigo-500"></div>
        
        <div class="mx-auto w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h1 class="text-3xl font-bold mb-2">Booking Reserved!</h1>
        <p class="text-slate-400 mb-8">Hi {{ $booking->customer_name }}, your booking has been recorded. Please complete the payment to secure your slot.</p>
        
        <div class="bg-slate-900 rounded-2xl p-6 border border-slate-700 mb-8 text-left">
            <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-800">
                <span class="text-slate-400">Booking Code</span>
                <span class="text-2xl font-bold text-indigo-400 tracking-wider">{{ $booking->booking_code }}</span>
            </div>
            <div class="grid grid-cols-2 gap-y-4 text-sm">
                <div class="text-slate-400">Package</div>
                <div class="text-right font-medium">{{ $booking->package->name }}</div>
                
                <div class="text-slate-400">Date & Time</div>
                <div class="text-right font-medium">{{ date('d M Y', strtotime($booking->booking_date)) }} at {{ date('H:i', strtotime($booking->booking_time)) }}</div>
                
                <div class="text-slate-400 pt-4 border-t border-slate-800">Total Amount</div>
                <div class="text-right pt-4 border-t border-slate-800 text-xl font-bold text-white">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="space-y-4">
            <p class="text-sm text-slate-400 mb-4">Please transfer the exact amount to:<br/>
            <strong class="text-white">BCA 1234567890 a.n Studioku Jogja</strong></p>
            
            <!-- Simulasi Bayar untuk MVP -->
            <button onclick="alert('Ini simulasi. Di tahap selanjutnya akan terhubung ke Midtrans/Xendit.')" class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-lg transition-all shadow-[0_0_30px_rgba(16,185,129,0.3)]">
                Pay Now (Midtrans Simulation)
            </button>
            
            <a href="{{ route('home') }}" class="block w-full py-4 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-medium transition-all">
                Return to Home
            </a>
        </div>
    </div>
</body>
</html>
