<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingWizardController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminJadwalController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Public & Customer Routes (Guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/testimoni', [HomeController::class, 'testimoni'])->name('testimoni');

// Shortcut /book and /book/{package_id} routes
Route::get('/book', function () {
    return redirect()->route('booking.step1');
});
Route::get('/book/{package_id}', function ($package_id) {
    return redirect()->route('booking.step1', ['package_id' => $package_id]);
});

// Multi-step Booking Wizard
Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/', [BookingWizardController::class, 'step1'])->name('step1'); // Pilih Paket
    Route::match(['get', 'post'], '/jadwal', [BookingWizardController::class, 'step2'])->name('step2'); // Pilih Tanggal & Waktu
    Route::match(['get', 'post'], '/data-diri', [BookingWizardController::class, 'step3'])->name('step3'); // Isi Data Diri
    Route::get('/konfirmasi', [BookingWizardController::class, 'step4'])->name('step4'); // Ringkasan & Konfirmasi
    Route::post('/', [BookingWizardController::class, 'store'])->name('store'); // Simpan booking
    Route::get('/sukses', [BookingWizardController::class, 'sukses'])->name('sukses'); // Halaman sukses
    
    // Status booking
    Route::get('/cek', [BookingWizardController::class, 'checkStatusForm'])->name('cek.form');
    Route::post('/cek', [BookingWizardController::class, 'checkStatus'])->name('cek.submit');
});

// Payment Gateway routes & Simulation
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
Route::post('/payment/simulate/{code}', [PaymentController::class, 'simulatePayment'])->name('payment.simulate');

// Admin Login Alias (as specified in PRD)
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']);
});

// Redirect /admin to /admin/dashboard
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

// Redirect /dashboard to /admin/dashboard (for Laravel Breeze auth redirects)
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Paket Layanan
    Route::resource('layanan', AdminPackageController::class)->except(['show']);
    
    // CRUD Galeri Foto
    Route::resource('galeri', AdminGalleryController::class)->only(['index', 'store', 'destroy']);
    
    // CRUD Testimoni
    Route::resource('testimoni', AdminTestimonialController::class)->except(['show']);
    
    // Kelola Semua Booking
    Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/export', [AdminBookingController::class, 'export'])->name('booking.export');
    Route::get('/booking/{id}', [AdminBookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('booking.updateStatus');
    
    // Kelola Jadwal & Blokir Slot
    Route::get('/jadwal', [AdminJadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/block', [AdminJadwalController::class, 'storeBlock'])->name('jadwal.block');
    Route::delete('/jadwal/block/{id}', [AdminJadwalController::class, 'destroyBlock'])->name('jadwal.destroyBlock');
    Route::post('/jadwal/settings', [AdminJadwalController::class, 'saveSettings'])->name('jadwal.saveSettings');
});

// Profile management (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
