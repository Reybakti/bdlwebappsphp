<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Banner;
use App\Models\Branch;
use App\Models\CompanyProfile;
use App\Models\PortalLink;
use App\Models\CsrProgram;
use App\Models\FinancialReport;
use App\Models\LpsInterestRate;
use App\Models\ManagementMember;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    /**
     * Halaman Beranda (Home)
     */
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

    /**
     * Profil Lembaga & Legalitas
     */
    public function aboutProfile()
    {
        $profile = CompanyProfile::first();
        $totalBranchesCount = Branch::where('is_active', true)->count();
        $commissionersCount = ManagementMember::where('is_active', true)->where('type', 'COMMISSIONER')->count();
        $directorsCount = ManagementMember::where('is_active', true)->where('type', 'DIRECTOR')->count();

        return view('public.about.profile', compact(
            'profile',
            'totalBranchesCount',
            'commissionersCount',
            'directorsCount'
        ));
    }

    /**
     * Dewan Direksi & Dewan Komisaris
     */
    public function aboutManagement()
    {
        $profile = CompanyProfile::first();

        $commissioners = ManagementMember::where('is_active', true)
            ->where('type', 'COMMISSIONER')
            ->orderBy('order_index')
            ->get();

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

    /**
     * Halaman Jaringan Kantor & Titik Layanan
     */
    public function branches(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = Branch::where('is_active', true);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('address', 'like', '%' . $search . '%');
            });
        }

        $branches = $query->orderByRaw("FIELD(type, 'HEAD_OFFICE', 'BRANCH', 'CASH_OFFICE')")
            ->orderBy('name')
            ->get();

        $totalBranches = Branch::where('is_active', true)->count();
        $headOffice = Branch::where('is_active', true)->where('type', 'HEAD_OFFICE')->first();
        $branchCount = Branch::where('is_active', true)->where('type', 'BRANCH')->count();
        $cashOfficeCount = Branch::where('is_active', true)->where('type', 'CASH_OFFICE')->count();

        return view('public.services.branches', compact(
            'profile',
            'branches',
            'headOffice',
            'totalBranches',
            'branchCount',
            'cashOfficeCount'
        ));
    }

    /**
     * Halaman Produk Pinjaman / Kredit
     */
    public function loanProducts()
    {
        $profile = CompanyProfile::first();

        $loanProducts = Product::with(['category', 'simulationParam'])
            ->whereHas('category', fn($q) => $q->where('slug', 'kredit'))
            ->where('is_active', true)
            ->get();

        $primaryLoan = $loanProducts->where('is_featured', true)->first() ?? $loanProducts->first();

        return view('public.products.loan', compact('profile', 'loanProducts', 'primaryLoan'));
    }

    /**
     * Halaman Informasi Tingkat Bunga Penjaminan (TBP) LPS
     */
    public function lpsRates()
    {
        $profile = CompanyProfile::first();

        $currentRate = LpsInterestRate::where('is_current', true)
            ->latest('effective_start_date')
            ->first();

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

        $query = Product::with(['category', 'simulationParam'])->where('is_active', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->orderBy('category_id')->orderBy('id')->get();

        return view('public.transparency.riplay', compact('profile', 'products'));
    }

    /**
     * 1. Berita & Agenda
     */
    public function mediaNews(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->whereHas('category', function ($q) {
                $q->where('slug', 'like', '%berita%')
                  ->orWhere('slug', 'like', '%agenda%')
                  ->orWhere('name', 'like', '%Berita%');
            });

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $pageTitle = 'Berita & Agenda Kegiatan';
        $pageSubtitle = 'Informasi terkini mengenai agenda korporasi, kegiatan cabang, dan warta resmi lembaga.';
        $activeCategory = 'berita';

        return view('public.media.index', compact('profile', 'articles', 'pageTitle', 'pageSubtitle', 'activeCategory'));
    }

    /**
     * 2. Edukasi & Literasi Keuangan
     */
    public function mediaEducation(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->whereHas('category', function ($q) {
                $q->where('slug', 'like', '%edukasi%')
                  ->orWhere('slug', 'like', '%literasi%')
                  ->orWhere('name', 'like', '%Edukasi%')
                  ->orWhere('name', 'like', '%Literasi%');
            });

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $pageTitle = 'Edukasi & Literasi Keuangan';
        $pageSubtitle = 'Materi panduan inklusi keuangan, tips mengelola angsuran kredit, keamanan bertransaksi, dan menabung sejak dini.';
        $activeCategory = 'edukasi';

        return view('public.media.index', compact('profile', 'articles', 'pageTitle', 'pageSubtitle', 'activeCategory'));
    }

    /**
     * 3. Pengumuman & Lelang Agunan
     */
    public function mediaAnnouncements(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->whereHas('category', function ($q) {
                $q->where('slug', 'like', '%pengumuman%')
                  ->orWhere('slug', 'like', '%lelang%')
                  ->orWhere('name', 'like', '%Pengumuman%')
                  ->orWhere('name', 'like', '%Lelang%');
            });

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $articles = $query->latest('published_at')->paginate(9)->withQueryString();
        $pageTitle = 'Pengumuman Resmi & Lelang Agunan';
        $pageSubtitle = 'Pemberitahuan operasional libur hari raya, informasi lelang eksekusi hak tanggungan, dan keterbukaan informasi publik.';
        $activeCategory = 'pengumuman';

        return view('public.media.index', compact('profile', 'articles', 'pageTitle', 'pageSubtitle', 'activeCategory'));
    }

    /**
     * Halaman Detail Artikel / Berita
     */
    public function mediaShow($slug)
    {
        $profile = CompanyProfile::first();

        $article = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedArticles = Article::with('category')
            ->where('status', 'PUBLISHED')
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('public.media.show', compact('profile', 'article', 'relatedArticles'));
    }

    /**
     * Halaman Daftar Lowongan Karier
     */
    public function careers(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = DB::table('career_postings')
            ->where('is_active', true)
            ->where('deadline', '>=', now()->toDateString());

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $vacancies = $query->orderBy('deadline', 'asc')->get();

        return view('public.services.career', compact('profile', 'vacancies'));
    }

    /**
     * Halaman Rincian Lowongan & Formulir Lamaran
     */
    public function careerDetail($slug)
    {
        $profile = CompanyProfile::first();

        $vacancy = DB::table('career_postings')
            ->where('is_active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.services.career-detail', compact('profile', 'vacancy'));
    }

    /**
     * Halaman Publik: Daftar Program CSR
     */
    public function csrIndex(Request $request)
    {
        $profile = CompanyProfile::first();

        $query = CsrProgram::where('is_published', true);

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $programs = $query->latest('activity_date')->paginate(9)->withQueryString();

        $counts = [
            'all' => CsrProgram::where('is_published', true)->count(),
            'umkm' => CsrProgram::where('is_published', true)->where('category', 'PEMBERDAYAAN_UMKM')->count(),
            'pendidikan' => CsrProgram::where('is_published', true)->where('category', 'PENDIDIKAN_LITERASI')->count(),
            'sosial' => CsrProgram::where('is_published', true)->where('category', 'SOSIAL_KEMASYARAKATAN')->count(),
            'lingkungan' => CsrProgram::where('is_published', true)->where('category', 'LINGKUNGAN_HIDUP')->count(),
        ];

        return view('public.csr.index', compact('profile', 'programs', 'counts'));
    }

    /**
     * Halaman Publik: Rincian Kegiatan CSR & Galeri Foto
     */
    public function csrDetail($slug)
    {
        $profile = CompanyProfile::first();

        $program = CsrProgram::with('galleryImages')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $otherPrograms = CsrProgram::where('is_published', true)
            ->where('id', '!=', $program->id)
            ->latest('activity_date')
            ->take(3)
            ->get();

        return view('public.csr.detail', compact('profile', 'program', 'otherPrograms'));
    }
    public function aboutStructure()
{
    $profile = CompanyProfile::first();
    $directors = ManagementMember::where('type', 'DIRECTOR')->where('is_active', true)->orderBy('order_index')->get();
    $commissioners = ManagementMember::where('type', 'COMMISSIONER')->where('is_active', true)->orderBy('order_index')->get();

    return view('public.about.structure', compact('profile', 'directors', 'commissioners'));
}
public function portalIndex()
{
    $portals = PortalLink::where('is_active', true)
        ->orderBy('order_index')
        ->get()
        ->groupBy('category');

    return view('public.portals.index', compact('portals'));
}

}