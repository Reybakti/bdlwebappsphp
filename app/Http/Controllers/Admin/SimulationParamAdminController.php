<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSimulationParam;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class SimulationParamAdminController extends Controller
{
    /**
     * Daftar Parameter Simulasi untuk Semua Produk Simpanan & Pinjaman
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'simulationParam'])
            ->whereHas('category', function ($q) {
                $q->whereIn('slug', ['kredit', 'deposito', 'tabungan']);
            });

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->orderBy('category_id')->orderBy('id')->paginate(10)->withQueryString();

        $counts = [
            'all' => Product::whereHas('category', fn($q) => $q->whereIn('slug', ['kredit', 'deposito', 'tabungan']))->count(),
            'kredit' => Product::whereHas('category', fn($q) => $q->where('slug', 'kredit'))->count(),
            'deposito' => Product::whereHas('category', fn($q) => $q->where('slug', 'deposito'))->count(),
        ];

        return view('admin.simulations.index', compact('products', 'counts'));
    }

    /**
     * Form Atur Parameter Simulasi Produk Tertentu
     */
    public function edit($productId)
    {
        $product = Product::with(['category', 'simulationParam'])->findOrFail($productId);
        $param = $product->simulationParam ?? new ProductSimulationParam(['product_id' => $product->id]);

        return view('admin.simulations.edit', compact('product', 'param'));
    }

    /**
     * Simpan / Perbarui Parameter Simulasi + Audit Log
     */
    public function update(Request $request, $productId)
    {
        $product = Product::with(['category', 'simulationParam'])->findOrFail($productId);
        $oldSnapshot = $product->simulationParam ? $product->simulationParam->toArray() : null;

        $validated = $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gte:min_amount',
            'min_tenor_months' => 'required|integer|min:1',
            'max_tenor_months' => 'required|integer|gte:min_tenor_months',
            'base_interest_rate_pa' => 'required|numeric|min:0|max:100',
            'calculation_method' => 'required|in:FLAT,ANNUITY,EFFECTIVE',
        ], [
            'min_amount.required' => 'Nominal minimum wajib diisi.',
            'max_amount.gte' => 'Nominal maksimum harus lebih besar atau sama dengan nominal minimum.',
            'min_tenor_months.required' => 'Tenor minimum wajib diisi.',
            'max_tenor_months.gte' => 'Tenor maksimum harus lebih besar atau sama dengan tenor minimum.',
            'base_interest_rate_pa.required' => 'Suku bunga dasar per tahun (p.a.) wajib diisi.',
            'calculation_method.required' => 'Pilih metode perhitungan bunga.',
        ]);

        $param = ProductSimulationParam::updateOrCreate(
            ['product_id' => $product->id],
            [
                'min_amount' => $validated['min_amount'],
                'max_amount' => $validated['max_amount'],
                'min_tenor_months' => $validated['min_tenor_months'],
                'max_tenor_months' => $validated['max_tenor_months'],
                'base_interest_rate_pa' => $validated['base_interest_rate_pa'],
                'calculation_method' => $validated['calculation_method'],
            ]
        );

        ActivityLogger::log(
            'SIMULATION_PARAM',
            $oldSnapshot ? 'UPDATE' : 'CREATE',
            "Mengatur parameter simulasi untuk produk: {$product->name} [Bunga: {$param->base_interest_rate_pa}% p.a.]",
            [
                'product_id' => $product->id,
                'before' => $oldSnapshot,
                'after' => $param->fresh()->toArray(),
            ]
        );

        return redirect()->route('admin.simulations.index')
            ->with('success', "Parameter simulasi untuk '{$product->name}' berhasil diperbarui.");
    }
}