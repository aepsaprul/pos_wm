<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductShop;
use App\Models\Sales;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stok_tersedia = Product::where('stock', '>', 20)->get();
        $stok_sedikit = Product::where('stock', '>', 0)->where('stock', '<=', 20)->get();
        $stok_habis = Product::where('stock', 0)->get();

        $count_stok_tersedia = count($stok_tersedia);
        $count_stok_sedikit = count($stok_sedikit);
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
            'count_stok_sedikit' => $count_stok_sedikit,
            'count_stok_habis' => $count_stok_habis,
            'produk_terlaris' => $produk_terlaris,
            'transaksi_kasir' => $transaksi_kasir
        ]);
    }

    public function show($id)
    {
        if ($id == "tersedia") {
            $title = "stok tersedia";
            $product = Product::with('productMaster')->where('stock', '>', 20)->limit(800)->get();
        } elseif ($id == "sedikit") {
            $title = "stok sedikit";
            $product = Product::with('productMaster')->where('stock', '>', 0)->where('stock', '<=', 20)->get();
        } elseif ($id == "habis") {
            $title = "stok habis";
            $product = Product::with('productMaster')->where('stock', 0)->get();
        } else {
            $title = "";
            $product = Product::with('productMaster')->limit(800)->get();
        }

        return view('pages.dashboard.show', ['title' => $title, 'products' => $product]);
    }

    public function shop()
    {
        $stok_tersedia = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->where('stock', '>', 20)->get();
        $stok_sedikit = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->where('stock', '>', 0)->where('stock', '<=', 20)->get();
        $stok_habis = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->where('stock', 0)->get();

        $count_stok_tersedia = count($stok_tersedia);
        $count_stok_sedikit = count($stok_sedikit);
        $count_stok_habis = count($stok_habis);

        $produk_terlaris = Sales::with('product')
            ->select('product_id','shop_id', DB::raw('sum(quantity) as total_qty'))
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->groupBy('product_id', 'shop_id')
            ->orderBy('total_qty', 'desc')
            ->get();

        $transaksi_kasir = Sales::with('user')
            ->select('user_id', 'shop_id', DB::raw('count(*) as total_transaksi'))
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->groupBy('user_id', 'shop_id')
            ->orderBy('total_transaksi', 'desc')
            ->get();

        return view('pages.dashboard.shop', [
            'count_stok_tersedia' => $count_stok_tersedia,
            'count_stok_sedikit' => $count_stok_sedikit,
            'count_stok_habis' => $count_stok_habis,
            'produk_terlaris' => $produk_terlaris,
            'transaksi_kasir' => $transaksi_kasir
        ]);
    }

    public function shopShow($id)
    {
        if ($id == "tersedia") {
            $title = "stok tersedia";
            $product = ProductShop::with(['product', 'product.productMaster'])->where('stock', '>', 20)->limit(800)->get();
        } elseif ($id == "sedikit") {
            $title = "stok sedikit";
            $product = ProductShop::with(['product', 'product.productMaster'])->where('stock', '>', 0)->where('stock', '<=', 20)->get();
        } elseif ($id == "habis") {
            $title = "stok habis";
            $product = ProductShop::with(['product', 'product.productMaster'])->where('stock', 0)->get();
        } else {
            $title = "";
            $product = ProductShop::with(['product', 'product.productMaster'])->limit(800)->get();
        }

        return view('pages.dashboard.shopShow', ['title' => $title, 'products' => $product]);
    }
}
