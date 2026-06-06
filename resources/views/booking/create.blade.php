<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book {{ $package->name }} | Studioku Jogja</title>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; } h1,h2,h3 { font-family: 'Outfit', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col">
    <nav class="w-full bg-slate-900/80 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center h-20">
            <a href="{{ route('home') }}" class="font-outfit font-bold text-2xl tracking-tight text-white">
                Studio<span class="text-indigo-400">ku</span>
            </a>
            <a href="{{ route('home') }}" class="ml-auto text-slate-400 hover:text-white transition-colors">
                &larr; Back to Packages
            </a>
        </div>
    </nav>

    <main class="flex-grow py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto w-full">
        <div class="bg-slate-800 border border-slate-700 rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-8 md:p-12">
                <h1 class="text-3xl font-bold mb-2">Book Your Session</h1>
                <p class="text-slate-400 mb-8">You are booking the <span class="text-indigo-400 font-semibold">{{ $package->name }}</span> package for <span class="text-white font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</span>.</p>

                @if ($errors->any())
                    <div class="mb-8 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
                        <ul class="list-disc list-inside text-red-400 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-300">Full Name</label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-600" placeholder="John Doe">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-300">Phone Number (WhatsApp)</label>
                            <input type="text" name="customer_phone" required value="{{ old('customer_phone') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-600" placeholder="08123456789">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-slate-300">Email Address</label>
                        <input type="email" name="customer_email" required value="{{ old('customer_email') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-slate-600" placeholder="john@example.com">
                        <p class="text-xs text-slate-500">We'll send your booking confirmation and softfiles here.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-700">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-300">Select Date</label>
                            <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [color-scheme:dark]">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-slate-300">Select Time</label>
                            <input type="time" name="booking_time" required value="{{ old('booking_time') }}" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all [color-scheme:dark]">
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit" class="w-full py-4 rounded-xl bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-lg transition-all shadow-[0_0_30px_rgba(99,102,241,0.3)] hover:shadow-[0_0_40px_rgba(99,102,241,0.5)]">
                            Confirm Booking & Pay
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
