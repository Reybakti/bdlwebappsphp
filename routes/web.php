<?php

use Illuminate\Support\Facades\Route;

// Controller Publik
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\WbsController;

// Controller Admin Backoffice
use App\Http\Controllers\Admin\ActivityLogAdminController;
use App\Http\Controllers\Admin\ArticleAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerAdminController;
use App\Http\Controllers\Admin\BranchAdminController;
use App\Http\Controllers\Admin\CareerAdminController;
use App\Http\Controllers\Admin\CompanyProfileAdminController;
use App\Http\Controllers\Admin\ComplaintAdminController;
use App\Http\Controllers\Admin\CsrAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FinancialReportAdminController;
use App\Http\Controllers\Admin\LpsRateAdminController;
use App\Http\Controllers\Admin\ManagementAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\SimulationParamAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\WbsAdminController;
use App\Http\Controllers\Admin\PortalLinkAdminController;

/*
|--------------------------------------------------------------------------
| 1. RUTE PORTAL PUBLIK RESMI BDL
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'index'])->name('home');

Route::prefix('tentang-kami')->group(function () {
    Route::get('/profil', [PublicController::class, 'aboutProfile'])->name('about.profile');
    Route::get('/manajemen', [PublicController::class, 'aboutManagement'])->name('about.management');
    Route::get('/struktur-organisasi', [PublicController::class, 'aboutStructure'])->name('about.structure'); // Rute Baru
    Route::get('/csr', [PublicController::class, 'csrIndex'])->name('about.csr');
    Route::get('/csr/{slug}', [PublicController::class, 'csrDetail'])->name('about.csr.detail');
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

    // Alias Pengaman
    Route::get('/laporan', [PublicController::class, 'financialReports'])->name('transparency.reports');
});

Route::prefix('media')->group(function () {
    Route::get('/berita-agenda', [PublicController::class, 'mediaNews'])->name('media.news');
    Route::get('/edukasi-literasi', [PublicController::class, 'mediaEducation'])->name('media.education');
    Route::get('/pengumuman-lelang', [PublicController::class, 'mediaAnnouncements'])->name('media.announcements');
    Route::get('/baca/{slug}', [PublicController::class, 'mediaShow'])->name('media.show');
});

Route::prefix('layanan')->group(function () {
    Route::get('/pengaduan', [ComplaintController::class, 'create'])->name('services.complaint');
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('services.complaint.store');
    Route::get('/cek-tiket', [ComplaintController::class, 'checkTicket'])->name('services.ticket');

    Route::get('/wbs', [WbsController::class, 'create'])->name('services.wbs');
    Route::post('/wbs', [WbsController::class, 'store'])->name('services.wbs.store');

    Route::get('/jaringan-kantor', [PublicController::class, 'branches'])->name('services.branches');
    Route::get('/karier', [PublicController::class, 'careers'])->name('services.career');
    Route::get('/karier/{slug}', [PublicController::class, 'careerDetail'])->name('services.career.detail');
    Route::post('/karier/{slug}/lamar', [PublicController::class, 'careerApply'])->name('services.career.apply');
});

Route::get('/portal-informasi', [PublicController::class, 'portalIndex'])->name('public.portals.index');
Route::get('/peta-situs', [PublicController::class, 'portalIndex'])->name('public.sitemap');

/*
|--------------------------------------------------------------------------
| 2. RUTE PORTAL KENDALI & BACKOFFICE (ADMIN)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Autentikasi Pengguna
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Area Terproteksi Login & Status Aktif
    Route::middleware(['role'])->group(function () {

        // Ringkasan Dashboard Utama
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ========================================================
        // A. KONTEN, MEDIA, PRODUK & INSTITUSI (Content Editor & Super Admin)
        // ========================================================
        Route::middleware(['role:content_editor'])->group(function () {

            // Profil Lembaga
            Route::get('/company-profile', [CompanyProfileAdminController::class, 'index'])->name('profile.index');
            Route::put('/company-profile', [CompanyProfileAdminController::class, 'update'])->name('profile.update');

            // Dewan Direksi & Dewan Komisaris
            Route::get('/management', [ManagementAdminController::class, 'index'])->name('management.index');
            Route::get('/management/create', [ManagementAdminController::class, 'create'])->name('management.create');
            Route::post('/management', [ManagementAdminController::class, 'store'])->name('management.store');
            Route::get('/management/{id}/edit', [ManagementAdminController::class, 'edit'])->name('management.edit');
            Route::put('/management/{id}', [ManagementAdminController::class, 'update'])->name('management.update');
            Route::delete('/management/{id}', [ManagementAdminController::class, 'destroy'])->name('management.destroy');

            // Katalog Produk & RIPLAY
            Route::get('/products', [ProductAdminController::class, 'index'])->name('products.index');
            Route::get('/products/create', [ProductAdminController::class, 'create'])->name('products.create');
            Route::post('/products', [ProductAdminController::class, 'store'])->name('products.store');
            Route::get('/products/{id}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
            Route::put('/products/{id}', [ProductAdminController::class, 'update'])->name('products.update');
            Route::delete('/products/{id}', [ProductAdminController::class, 'destroy'])->name('products.destroy');

            // Parameter Simulasi Produk (Kredit & Deposito)
            Route::get('/simulations', [SimulationParamAdminController::class, 'index'])->name('simulations.index');
            Route::get('/simulations/{productId}/edit', [SimulationParamAdminController::class, 'edit'])->name('simulations.edit');
            Route::put('/simulations/{productId}', [SimulationParamAdminController::class, 'update'])->name('simulations.update');

            // Jaringan Kantor & Titik Kas
            Route::get('/branches', [BranchAdminController::class, 'index'])->name('branches.index');
            Route::get('/branches/create', [BranchAdminController::class, 'create'])->name('branches.create');
            Route::post('/branches', [BranchAdminController::class, 'store'])->name('branches.store');
            Route::get('/branches/{id}/edit', [BranchAdminController::class, 'edit'])->name('branches.edit');
            Route::put('/branches/{id}', [BranchAdminController::class, 'update'])->name('branches.update');
            Route::delete('/branches/{id}', [BranchAdminController::class, 'destroy'])->name('branches.destroy');

            // Hero Banner Slider
            Route::get('/banners', [BannerAdminController::class, 'index'])->name('banners.index');
            Route::get('/banners/create', [BannerAdminController::class, 'create'])->name('banners.create');
            Route::post('/banners', [BannerAdminController::class, 'store'])->name('banners.store');
            Route::get('/banners/{id}/edit', [BannerAdminController::class, 'edit'])->name('banners.edit');
            Route::put('/banners/{id}', [BannerAdminController::class, 'update'])->name('banners.update');
            Route::delete('/banners/{id}', [BannerAdminController::class, 'destroy'])->name('banners.destroy');

            // Program Tanggung Jawab Sosial dan Lingkungan (CSR)
            Route::get('/csr', [CsrAdminController::class, 'index'])->name('csr.index');
            Route::get('/csr/create', [CsrAdminController::class, 'create'])->name('csr.create');
            Route::post('/csr', [CsrAdminController::class, 'store'])->name('csr.store');
            Route::get('/csr/{id}/edit', [CsrAdminController::class, 'edit'])->name('csr.edit');
            Route::put('/csr/{id}', [CsrAdminController::class, 'update'])->name('csr.update');
            Route::delete('/csr/{id}', [CsrAdminController::class, 'destroy'])->name('csr.destroy');
            Route::delete('/csr/image/{id}', [CsrAdminController::class, 'deleteImage'])->name('csr.image.delete');

            // Warta & Edukasi Literasi
            Route::get('/articles', [ArticleAdminController::class, 'index'])->name('articles.index');
            Route::get('/articles/create', [ArticleAdminController::class, 'create'])->name('articles.create');
            Route::post('/articles', [ArticleAdminController::class, 'store'])->name('articles.store');
            Route::get('/articles/{id}/edit', [ArticleAdminController::class, 'edit'])->name('articles.edit');
            Route::put('/articles/{id}', [ArticleAdminController::class, 'update'])->name('articles.update');
            Route::delete('/articles/{id}', [ArticleAdminController::class, 'destroy'])->name('articles.destroy');

            // Rekrutmen Karier
            Route::get('/careers', [CareerAdminController::class, 'index'])->name('careers.index');
            Route::get('/careers/create', [CareerAdminController::class, 'create'])->name('careers.create');
            Route::post('/careers', [CareerAdminController::class, 'store'])->name('careers.store');
            Route::get('/careers/{id}/edit', [CareerAdminController::class, 'edit'])->name('careers.edit');
            Route::put('/careers/{id}', [CareerAdminController::class, 'update'])->name('careers.update');
            Route::delete('/careers/{id}', [CareerAdminController::class, 'destroy'])->name('careers.destroy');
            Route::resource('portals', PortalLinkAdminController::class)->except(['show']);
        });

        // ========================================================
        // B. KEPATUHAN & REGULASI (Compliance Officer & Super Admin)
        // ========================================================
        Route::middleware(['role:compliance_officer'])->group(function () {

            // Pengaduan Nasabah (POJK 22/2023)
            Route::get('/complaints', [ComplaintAdminController::class, 'index'])->name('complaints.index');
            Route::get('/complaints/{id}', [ComplaintAdminController::class, 'show'])->name('complaints.show');
            Route::put('/complaints/{id}', [ComplaintAdminController::class, 'update'])->name('complaints.update');

            // Whistleblowing System (WBS)
            Route::get('/wbs', [WbsAdminController::class, 'index'])->name('wbs.index');
            Route::get('/wbs/{id}', [WbsAdminController::class, 'show'])->name('wbs.show');
            Route::put('/wbs/{id}', [WbsAdminController::class, 'update'])->name('wbs.update');

            // Laporan Publikasi Keuangan & GCG
            Route::get('/financial-reports', [FinancialReportAdminController::class, 'index'])->name('reports.index');
            Route::get('/financial-reports/create', [FinancialReportAdminController::class, 'create'])->name('reports.create');
            Route::post('/financial-reports', [FinancialReportAdminController::class, 'store'])->name('reports.store');
            Route::get('/financial-reports/{id}/edit', [FinancialReportAdminController::class, 'edit'])->name('reports.edit');
            Route::put('/financial-reports/{id}', [FinancialReportAdminController::class, 'update'])->name('reports.update');
            Route::delete('/financial-reports/{id}', [FinancialReportAdminController::class, 'destroy'])->name('reports.destroy');

            // Suku Bunga LPS
            Route::get('/lps-rates', [LpsRateAdminController::class, 'index'])->name('lps.index');
            Route::get('/lps-rates/create', [LpsRateAdminController::class, 'create'])->name('lps.create');
            Route::post('/lps-rates', [LpsRateAdminController::class, 'store'])->name('lps.store');
            Route::get('/lps-rates/{id}/edit', [LpsRateAdminController::class, 'edit'])->name('lps.edit');
            Route::put('/lps-rates/{id}', [LpsRateAdminController::class, 'update'])->name('lps.update');
            Route::patch('/lps-rates/{id}/set-current', [LpsRateAdminController::class, 'setCurrent'])->name('lps.set_current');
            Route::delete('/lps-rates/{id}', [LpsRateAdminController::class, 'destroy'])->name('lps.destroy');
        });

        // ========================================================
        // C. TATA KELOLA IT & AUDIT TRAIL (Khusus Super Admin)
        // ========================================================
        Route::middleware(['role:super_admin'])->group(function () {

            // Rekam Jejak Audit Log Aktivitas
            Route::get('/activity-logs', [ActivityLogAdminController::class, 'index'])->name('activity_logs.index');

            // Manajemen Pengguna & Hak Akses
            Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserAdminController::class, 'create'])->name('users.create');
            Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/edit', [UserAdminController::class, 'edit'])->name('users.edit');
            Route::put('/users/{id}', [UserAdminController::class, 'update'])->name('users.update');
            Route::delete('/users/{id}', [UserAdminController::class, 'destroy'])->name('users.destroy');
        });

    });
});