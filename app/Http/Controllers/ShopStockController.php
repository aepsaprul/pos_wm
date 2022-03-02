<?php

namespace App\Http\Controllers;

use App\Models\ShopStock;
use Illuminate\Http\Request;

class ShopStockController extends Controller
{
    public function index()
    {
        return view('pages.shop_stock.index');
    }

    public function getData() {
        $stock = ShopStock::with('product')->get();

        return response()->json([
            'stocks' => $stock
        ]);
    }

    public function low()
    {
        $stock = ShopStock::with('product')->whereBetween('stock', [1, 20])->get();

        return response()->json([
            'stocks' => $stock
        ]);
    }

    public function empty()
    {
        $stock = ShopStock::with('product')->where('stock', 0)->get();

        return response()->json([
            'stocks' => $stock
        ]);
    }
}
