<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\InventoryInvoice;
use App\Models\InventoryProductOut;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopBuyController extends Controller
{
    public function index()
    {
        if (Auth::user()->employee) {
            $product = Product::paginate(60);
            return view('pages.shop_buy.index', ['products' => $product]);
        } else {
            return view('page_403');
        }
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
        $cart_first = Cart::where('shop_id', Auth::user()->employee->shop_id)->first();
        if ($cart_first != null) {
            $shop_id = $cart_first->shop_id;
        } else {
            $shop_id = 0;
        }

        $count_price = Cart::where('shop_id', Auth::user()->employee->shop_id)
            ->select(DB::raw('SUM(price) as total_sales'))
            ->get();

        $total_price = "";
        foreach ($count_price as $key => $value) {
            $total_price = $value->total_sales;
        }

        return view('pages.shop_buy.cart', ['carts' => $cart, 'shop_id' => $shop_id, 'total_price' => $total_price]);
    }

    public function cartStore(Request $request)
    {
        $product = Product::find($request->product_id);
        $price = $product->product_price_selling * $request->qty;
        $total_cart = count(Cart::where('shop_id', Auth::user()->employee->shop_id)->where('product_id', $request->product_id)->get());

        if ($total_cart > 0) {
            $cart = Cart::where('shop_id', Auth::user()->employee->shop_id)->where('product_id', $request->product_id)->first();
            $cart->qty = $cart->qty + $request->qty;
            $cart->price = $cart->price + $price;
            $cart->save();
        } else {
            $cart = new Cart;
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->price = $price;
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

    public function cartQty(Request $request)
    {
        $cart = Cart::find($request->id);

        $product = Product::find($cart->product_id);

        if ($request->value == "plus") {
            $cart->qty = $cart->qty + 1;
            $cart->price = $cart->price + $product->product_price_selling;
        } else if ($request->value == "minus") {
            $cart->qty = $cart->qty - 1;
            $cart->price = $cart->price - $product->product_price_selling;
        } else {
            if ($request->qty < $cart->qty) {
                $qty = $cart->qty - $request->qty;
                $price = $product->product_price_selling * $qty;

                $cart->qty = $cart->qty - $qty;
                $cart->price = $cart->price - $price;
            } else {
                $qty = $request->qty - $cart->qty;
                $price = $product->product_price_selling * $qty;

                $cart->qty = $cart->qty + $qty;
                $cart->price = $cart->price + $price;
            }
        }

        $cart->save();

        $count_price = Cart::where('shop_id', Auth::user()->employee->shop_id)
            ->select(DB::raw('SUM(price) as total_sales'))
            ->get();

        $total_price = "";
        foreach ($count_price as $key => $value) {
            $total_price = $value->total_sales;
        }

        return response()->json([
            'cart' => $cart,
            'total_price' => $total_price
        ]);
    }

    public function cartDeleteAll(Request $request)
    {
        $cart = Cart::where('shop_id', $request->id);
        $cart->delete();

        return response()->json([
            'status' => 200
        ]);
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->delete();

        return response()->json([
            'status' => 200
        ]);
    }

    public function cartFinish(Request $request)
    {
        $invoice_code = Str::random(10);

        $invoice = new InventoryInvoice;
        $invoice->total_amount = $request->total_price;
        $invoice->date_recorded = date('Y-m-d H:i:s');
        $invoice->user_id = Auth::user()->id;
        $invoice->shop_id = $request->shop_id;
        $invoice->code = $invoice_code;
        $invoice->payment_methods = $request->payment_methods;
        $invoice->save();

        $cart = Cart::where('shop_id', $request->shop_id)->get();

        foreach ($cart as $key => $value) {
            $product_out = new InventoryProductOut;
            $product_out->user_id = Auth::user()->id;
            $product_out->shop_id = $request->shop_id;
            $product_out->product_id = $value->product_id;
            $product_out->quantity = $value->qty;
            $product_out->sub_total = $value->price;
            $product_out->invoice_id = $invoice->id;
            $product_out->save();
        }

        $cart_delete = Cart::where('shop_id', $request->shop_id);
        $cart_delete->delete();

        return response()->json([
            'status' => 200,
            'code' => $invoice_code
        ]);
    }

    public function cartInvoice($code)
    {
        $invoice = InventoryInvoice::where('code', $code)->first();

        return view('pages.shop_buy.invoice', ['invoices' => $invoice]);
    }
}
