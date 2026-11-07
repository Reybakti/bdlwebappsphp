<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\LpsInterestRate;
use App\Models\Product;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * Tampilan Halaman Deposito Berjangka
     */
    public function depositPage()
    {
        $profile = CompanyProfile::first();

        // 1. Ambil Produk Kategori Deposito Aktif
        $depositProducts = Product::with(['category', 'simulationParam'])
            ->whereHas('category', fn($q) => $q->where('slug', 'deposito'))
            ->where('is_active', true)
            ->get();

        $primaryDeposit = $depositProducts->where('is_featured', true)->first() ?? $depositProducts->first();

        // 2. Suku Bunga LPS BPR Aktif
        $lpsRate = LpsInterestRate::where('is_current', true)
            ->latest('effective_start_date')
            ->first();

        return view('public.products.deposit', compact('profile', 'depositProducts', 'primaryDeposit', 'lpsRate'));
    }

    /**
     * Tampilan Halaman Kredit Usaha
     */
    public function loanPage()
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
     * Endpoint API/Form Simulasi Deposito (Opsional untuk AJAX)
     */
    public function calculateDeposit(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000000',
            'tenor_months' => 'required|integer|in:1,3,6,12',
            'rate_pa' => 'nullable|numeric|min:0.1',
        ]);

        $principal = (float) $validated['amount'];
        $tenor = (int) $validated['tenor_months'];

        // Gunakan rate LPS aktif atau parameter default
        $lps = LpsInterestRate::where('is_current', true)->latest('effective_start_date')->first();
        $ratePa = $validated['rate_pa'] ?? ($lps?->rate_idr ?? 6.75);

        // Rumus Bunga Deposito Perbankan:
        // Bunga Kotor per bulan = (Nominal * Rate) / 12
        $grossMonthly = ($principal * ($ratePa / 100)) / 12;
        $grossTotal = $grossMonthly * $tenor;

        // Pajak PPh 20% jika nominal >= Rp7.500.000
        $taxRate = ($principal >= 7500000) ? 0.20 : 0.00;
        $taxMonthly = $grossMonthly * $taxRate;
        $netMonthly = $grossMonthly - $taxMonthly;
        $netTotal = $grossTotal * (1 - $taxRate);

        return response()->json([
            'principal' => $principal,
            'tenor_months' => $tenor,
            'rate_pa' => $ratePa,
            'is_taxable' => $principal >= 7500000,
            'tax_rate_pct' => $taxRate * 100,
            'gross_monthly' => round($grossMonthly),
            'gross_total' => round($grossTotal),
            'tax_monthly' => round($taxMonthly),
            'net_monthly' => round($netMonthly),
            'net_total' => round($netTotal),
            'final_balance' => round($principal + $netTotal),
        ]);
    }

    /**
     * Endpoint API/Form Simulasi Kredit
     */
    public function calculateLoan(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1000000',
            'tenor_months' => 'required|integer|min:1|max:60',
            'rate_pa' => 'nullable|numeric|min:0.1',
            'provision_pct' => 'nullable|numeric|min:0',
        ]);

        $principal = (float) $validated['amount'];
        $tenor = (int) $validated['tenor_months'];
        $ratePa = $validated['rate_pa'] ?? 10.50;
        $provisionPct = $validated['provision_pct'] ?? 1.0;

        $principalMonthly = $principal / $tenor;
        $interestMonthly = ($principal * ($ratePa / 100)) / 12;
        $totalMonthly = $principalMonthly + $interestMonthly;
        $provisionFee = $principal * ($provisionPct / 100);

        return response()->json([
            'principal' => $principal,
            'tenor_months' => $tenor,
            'rate_pa' => $ratePa,
            'principal_monthly' => round($principalMonthly),
            'interest_monthly' => round($interestMonthly),
            'total_monthly' => round($totalMonthly),
            'provision_fee' => round($provisionFee),
            'total_repayment' => round($totalMonthly * $tenor),
        ]);
    }
    /**
     * Tampilan Halaman Produk Tabungan
     */
    public function savingsPage()
    {
        $profile = CompanyProfile::first();

        // Ambil seluruh produk tabungan aktif beserta kategorinya
        $savingsProducts = Product::with(['category', 'simulationParam'])
            ->whereHas('category', fn($q) => $q->where('slug', 'tabungan'))
            ->where('is_active', true)
            ->get();

        $lpsRate = LpsInterestRate::where('is_current', true)
            ->latest('effective_start_date')
            ->first();

        return view('public.products.savings', compact('profile', 'savingsProducts', 'lpsRate'));
    }
}