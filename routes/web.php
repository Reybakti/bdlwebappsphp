<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\WbsController;
use Illuminate\Support\Facades\Route;

// ==========================================
// Rute Publik Portal Resmi BDL
// ==========================================
Route::get('/', [PublicController::class, 'index'])->name('home');

Route::prefix('tentang-kami')->group(function () {
    Route::get('/profil', [PublicController::class, 'aboutProfile'])->name('about.profile');
    Route::get('/manajemen', [PublicController::class, 'aboutManagement'])->name('about.management');
});

Route::prefix('produk')->group(function () {
    Route::get('/tabungan', [SimulationController::class, 'savingsPage'])->name('products.savings');
    Route::get('/deposito', [SimulationController::class, 'depositPage'])->name('products.deposit');
    Route::get('/kredit', [SimulationController::class, 'loanPage'])->name('products.loan');
    Route::post('/simulasi/kredit', [SimulationController::class, 'calculateLoan'])->name('simulation.loan');
    Route::post('/simulasi/deposito', [SimulationController::class, 'calculateDeposit'])->name('simulation.deposit');
});

Route::prefix('transparansi')->group(function () {
    Route::get('/laporan-keuangan', [PublicController::class, 'financialReports'])->name('transparency.financial');
    Route::get('/laporan-gcg', [PublicController::class, 'gcgReports'])->name('transparency.gcg');
    Route::get('/suku-bunga-lps', [PublicController::class, 'lpsRates'])->name('transparency.lps');
    Route::get('/riplay', [PublicController::class, 'riplay'])->name('transparency.riplay');

    // Alias pengaman
    Route::get('/laporan', [PublicController::class, 'financialReports'])->name('transparency.reports');
});

Route::prefix('layanan')->group(function () {
    Route::get('/pengaduan', [ComplaintController::class, 'create'])->name('services.complaint');
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('services.complaint.store');
    Route::get('/cek-tiket', [ComplaintController::class, 'checkTicket'])->name('services.ticket');

    Route::get('/wbs', [WbsController::class, 'create'])->name('services.wbs');
    Route::post('/wbs', [WbsController::class, 'store'])->name('services.wbs.store');

    Route::get('/jaringan-kantor', [PublicController::class, 'branches'])->name('services.branches');
});