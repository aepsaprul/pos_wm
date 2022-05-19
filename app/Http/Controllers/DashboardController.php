<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stok_tersedia = Product::where('stock', '>', 20)->get();
        $stok_hampir_habis = Product::where('stock', '>', 0)->where('stock', '<=', 20)->get();
        $stok_habis = Product::where('stock', 0)->get();

        $count_stok_tersedia = count($stok_tersedia);
        $count_stok_hampir_habis = count($stok_hampir_habis);
        $count_stok_habis = count($stok_habis);

        $produk_terlaris = Sales::with('product')
            ->select('product_id', DB::raw('sum(quantity) as total_qty'))
            ->groupBy('product_id')
            ->orderBy('total_qty', 'desc')
            ->get();

        $transaksi_kasir = Sales::with('user')
            ->select('user_id', 'shop_id', DB::raw('count(*) as total_transaksi'))
            ->groupBy('user_id', 'shop_id')
            ->orderBy('total_transaksi', 'desc')
            ->get();

        return view('pages.dashboard.index', [
            'count_stok_tersedia' => $count_stok_tersedia,
            'count_stok_hampir_habis' => $count_stok_hampir_habis,
            'count_stok_habis' => $count_stok_habis,
            'produk_terlaris' => $produk_terlaris,
            'transaksi_kasir' => $transaksi_kasir
        ]);
    }
}
