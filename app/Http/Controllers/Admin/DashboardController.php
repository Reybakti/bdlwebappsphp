<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Branch;
use App\Models\CareerPosting;
use App\Models\CustomerComplaint;
use App\Models\FinancialReport;
use App\Models\Product;
use App\Models\WbsReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentYear = (int) date('Y');

        // 1. Stat Metric Utama
        $pendingComplaintsCount = CustomerComplaint::whereIn('status', ['RECEIVED', 'IN_REVIEW'])->count();
        $totalComplaintsCount = CustomerComplaint::count();$resolvedComplaintsCount = CustomerComplaint::where('status', 'RESOLVED')->count();

        $submittedWbsCount = WbsReport::whereIn('status', ['RECEIVED', 'IN_INVESTIGATION'])->count();
        $totalWbsCount = WbsReport::count();$resolvedWbsCount = WbsReport::whereIn('status', ['CLOSED', 'IN_INVESTIGATION'])->count();

        $activeProductsCount = Product::where('is_active', true)->count();$activeBranchesCount = Branch::where('is_active', true)->count();

        // 2. Persentase Efektivitas Layanan (Gauge Meters)
        $complaintSlaRate =$totalComplaintsCount > 0 
            ? round(($resolvedComplaintsCount / $totalComplaintsCount) * 100) 
            : 100;

        $wbsResponseRate =$totalWbsCount > 0 
            ? round(($resolvedWbsCount / $totalWbsCount) * 100) 
            : 100;

        // 3. Data Grafik Batang Aktivitas Bulanan (Tahun Berjalan)
        $monthlyIncoming = CustomerComplaint::whereYear('created_at',$currentYear)
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $monthlyResolved = CustomerComplaint::whereYear('created_at',$currentYear)
            ->where('status', 'RESOLVED')
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartData = [];$maxVal = 1;

        for ($m = 1; $m <= 12; $m++) {$in = $monthlyIncoming[$m] ?? 0;
            $res = $monthlyResolved[$m] ?? 0;
            if ($in >$maxVal) $maxVal =$in;
            if ($res >$maxVal) $maxVal =$res;

            $chartData[] = [
                'name' => $months[$m - 1], 'in' =>$in,
                'resolved' => $res,
            ];
        }

        // Hitung tinggi persentase relatif bar grafik
        foreach ($chartData as &$item) {
            $item['in_height'] =$maxVal > 0 ? max(8, round(($item['in'] /$maxVal) * 100)) : 8;
            $item['res_height'] =$maxVal > 0 ? max(8, round(($item['resolved'] /$maxVal) * 100)) : 8;
        }
        unset($item);

        // 4. Banner Metrik Tambahan
        $totalReportsCount = FinancialReport::count();
        $totalArticlesCount = Article::where('status', 'PUBLISHED')->count();$activeCareersCount = CareerPosting::where('is_active', true)->count();

        // 5. Tabel Pengaduan Nasabah Terkini (5 Terakhir)
        $latestComplaints = CustomerComplaint::latest()->take(5)->get();

        // 6. Distribusi Keluhan Berdasarkan Kategori Layanan
        $complaintCategories = CustomerComplaint::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'pendingComplaintsCount',
            'totalComplaintsCount',
            'submittedWbsCount',
            'totalWbsCount',
            'activeProductsCount',
            'activeBranchesCount',
            'complaintSlaRate',
            'wbsResponseRate',
            'chartData',
            'currentYear',
            'totalReportsCount',
            'totalArticlesCount',
            'activeCareersCount',
            'latestComplaints',
            'complaintCategories'
        ));
    }
}