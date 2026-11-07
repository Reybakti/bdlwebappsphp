<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\CompanyProfile;
use App\Models\FinancialReport;
use App\Models\LpsInterestRate;
use App\Models\ManagementMember;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // 1. Banner Slider Aktif Terurut
        $banners = Banner::where('is_active', true)->orderBy('order_index')->get();

        // 2. Profil Lembaga
        $profile = CompanyProfile::first();

        // 3. Produk Unggulan beserta Kategori & Parameter Simulasinya
        $featuredProducts = Product::with(['category', 'simulationParam'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->get();

        // 4. Produk Khusus untuk Pengaturan Nilai Default Kalkulator (Kredit & Deposito)
        $loanProduct = Product::with('simulationParam')
            ->whereHas('category', fn($q) => $q->where('slug', 'kredit'))
            ->where('is_active', true)
            ->first();

        $depositProduct = Product::with('simulationParam')
            ->whereHas('category', fn($q) => $q->where('slug', 'deposito'))
            ->where('is_active', true)
            ->first();

        // 5. Suku Bunga Penjaminan LPS Aktif Terkini
        $lpsRate = LpsInterestRate::where('is_current', true)->latest('effective_start_date')->first();

        // 6. Laporan Keuangan & GCG Terbaru untuk Widget Transparansi
        $latestFinancialReport = FinancialReport::where('type', '!=', 'GCG')
            ->orderByDesc('year')
            ->orderByDesc('published_at')
            ->first();

        $latestGcgReport = FinancialReport::where('type', 'GCG')
            ->orderByDesc('year')
            ->orderByDesc('published_at')
            ->first();

        // 7. Berita & Edukasi Terpublikasi Terbaru
        $latestArticles = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->latest('published_at')
            ->take(3)
            ->get();

        // 8. Seluruh Jaringan Kantor Aktif
        $branches = Branch::where('is_active', true)->get();
        $totalBranchesCount = $branches->count();

        return view('public.home', compact(
            'banners',
            'profile',
            'featuredProducts',
            'loanProduct',
            'depositProduct',
            'lpsRate',
            'latestFinancialReport',
            'latestGcgReport',
            'latestArticles',
            'branches',
            'totalBranchesCount'
        ));
    }

    public function aboutProfile()
    {
        $profile = CompanyProfile::first();$totalBranchesCount = Branch::where('is_active', true)->count();
        $commissionersCount = ManagementMember::where('is_active', true)->where('type', 'COMMISSIONER')->count();$directorsCount = ManagementMember::where('is_active', true)->where('type', 'DIRECTOR')->count();

        return view('public.about.profile', compact(
            'profile',
            'totalBranchesCount',
            'commissionersCount',
            'directorsCount'
        ));
    }

    public function aboutManagement()
    {
        $profile = CompanyProfile::first();

        // 1. Dewan Komisaris Aktif
        $commissioners = ManagementMember::where('is_active', true)
            ->where('type', 'COMMISSIONER')
            ->orderBy('order_index')
            ->get();

        // 2. Direksi Aktif
        $directors = ManagementMember::where('is_active', true)
            ->where('type', 'DIRECTOR')
            ->orderBy('order_index')
            ->get();

        return view('public.about.management', compact('profile', 'commissioners', 'directors'));
    }

    /**
     * Halaman Khusus Laporan Keuangan Publikasi (Triwulan I-IV & Tahunan Audited)
     */
    public function financialReports(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = FinancialReport::where('type', '!=', 'GCG');

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $reports = $query->orderByDesc('year')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $availableYears = FinancialReport::where('type', '!=', 'GCG')
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('public.transparency.financial', compact('profile', 'reports', 'availableYears'));
    }

    /**
     * Halaman Khusus Laporan Penerapan Tata Kelola (GCG)
     */
    public function gcgReports(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = FinancialReport::where('type', 'GCG');

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $reports = $query->orderByDesc('year')
            ->orderByDesc('published_at')
            ->paginate(10)
            ->withQueryString();

        $availableYears = FinancialReport::where('type', 'GCG')
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        return view('public.transparency.gcg', compact('profile', 'reports', 'availableYears'));
    }

    public function branches()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('public.services.branches', compact('branches'));
    }
    public function loanProducts()
    {
        $profile = CompanyProfile::first();

        // 1. Ambil seluruh produk pinjaman/kredit aktif beserta parameter simulasinya
        $loanProducts = Product::with(['category', 'simulationParam'])
            ->whereHas('category', fn($q) => $q->where('slug', 'kredit'))
            ->where('is_active', true)
            ->get();

        // 2. Produk kredit utama untuk kalkulator default
        $primaryLoan = $loanProducts->where('is_featured', true)->first() ?? $loanProducts->first();

        return view('public.products.loan', compact('profile', 'loanProducts', 'primaryLoan'));
    }

    /**
     * Halaman Informasi Tingkat Bunga Penjaminan (TBP) LPS
     */
    public function lpsRates()
    {
        $profile = CompanyProfile::first();

        // 1. Suku Bunga LPS Aktif Saat Ini
        $currentRate = LpsInterestRate::where('is_current', true)
            ->latest('effective_start_date')
            ->first();

        // 2. Riwayat Perubahan Suku Bunga LPS
        $rateHistories = LpsInterestRate::orderByDesc('effective_start_date')
            ->paginate(10);

        return view('public.transparency.lps', compact('profile', 'currentRate', 'rateHistories'));
    }

    /**
     * Halaman Ringkasan Informasi Produk dan Layanan (RIPLAY)
     */
    public function riplay(Request $request)
    {
        $profile = CompanyProfile::first();

        // Query Produk Aktif beserta Kategori dan Parameter Simulasinya
        $query = Product::with(['category', 'simulationParam'])->where('is_active', true);

        // Filter berdasarkan kategori jika dipilih (tabungan, deposito, kredit)
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->orderBy('category_id')->orderBy('order_index')->get();

        return view('public.transparency.riplay', compact('profile', 'products'));
    }
}