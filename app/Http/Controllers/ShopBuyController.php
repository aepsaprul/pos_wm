<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopBuyController extends Controller
{
    public function index() {
        $product = Product::paginate(60);

        return view('pages.shop_buy.index', ['products' => $product]);
    }

    public function search(Request $request)
    {
        $product = Product::where('product_name', 'like', '%' . $request->search . '%')->paginate(60);

        return view('pages.shop_buy.index', ['products' => $product]);
    }

    public function store(Request $request)
    {

    }
}
