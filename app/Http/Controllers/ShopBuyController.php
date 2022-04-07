<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function detail($id)
    {
        $product = Product::find($id);

        return response()->json([
            'product' => $product
        ]);
    }

    public function cart()
    {
        $cart = Cart::where('shop_id', Auth::user()->employee->shop_id)->get();

        return view('pages.shop_buy.cart', ['carts' => $cart]);
    }

    public function cartStore(Request $request)
    {
        $total_cart = count(Cart::where('shop_id', Auth::user()->employee->shop_id)->where('product_id', $request->product_id)->get());

        if ($total_cart > 0) {
            $cart = Cart::where('shop_id', Auth::user()->employee->shop_id)->where('product_id', $request->product_id)->first();
            $cart->qty = $cart->qty + $request->qty;
            $cart->price = $cart->price + $request->price;
            $cart->save();
        } else {
            $cart = new Cart;
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->price = $request->price;
            $cart->shop_id = $request->shop_id;
            $cart->save();
        }

        $count_cart = count(Cart::where('shop_id', Auth::user()->employee->shop_id)->get());

        return response()->json([
            'status' => 200,
            'count_cart' => $count_cart,
            'total_cart' => $total_cart
        ]);
    }
}
