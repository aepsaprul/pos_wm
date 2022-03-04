<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductShop;
use App\Models\ReceiveProduct;
use App\Models\ShopStock;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiveProductController extends Controller
{
    public function index()
    {
        if (Auth::user()->employee) {
            $receive_product = ReceiveProduct::where('shop_id', Auth::user()->employee->shop_id)->get();
            return view('pages.receive_product.index', ['receive_products' => $receive_product]);
        } else {
            return view('page_403');
        }

    }

    public function create()
    {
        $product = ProductShop::with('product')->where('shop_id', Auth::user()->employee->shop_id)->get();

        return response()->json([
            'products' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $receive_product = new ReceiveProduct;
        $receive_product->user_id = Auth::user()->id;
        $receive_product->shop_id = Auth::user()->employee->shop_id;
        $receive_product->product_id = $request->product_id;
        $receive_product->price = $product->product_price_selling;
        $receive_product->quantity = $request->quantity;
        $receive_product->sub_total = $request->quantity * $product->product_price_selling;
        $receive_product->stock = $request->quantity;
        $receive_product->date = date('Y-m-d H:i:s');
        $receive_product->save();

        // $stock = ShopStock::where('product_id', $request->product_id)->first();

        // if ($stock) {
        //     $stock->stock = $stock->stock + $request->quantity;
        //     $stock->save();
        // } else {
        //     $new_stock = new ShopStock;
        //     $new_stock->product_id = $request->product_id;
        //     $new_stock->stock = $request->quantity;
        //     $new_stock->save();
        // }

        $stock = ProductShop::where('product_id', $request->product_id)
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->first();
        $stock->stock = $stock->stock + $request->quantity;
        $stock->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $received_product = ReceiveProduct::find($id);
        $product = ProductShop::with('product')->where('shop_id', Auth::user()->employee->shop_id)->get();

        return response()->json([
            'id' => $received_product->id,
            'product_id' => $received_product->product_id,
            'quantity' => $received_product->quantity,
            'products' => $product
        ]);
    }

    public function update(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $receive_product = ReceiveProduct::find($request->id);

        // update stock
        $quantity = $request->quantity;
        $quantityNow = $receive_product->quantity;

        // $stock = ShopStock::where('product_id', $request->product_id)->first();
        $stock = ProductShop::where('product_id', $request->product_id)
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->first();

        if ($quantity > $quantityNow) {
            $diff = $quantity - $quantityNow;

            $stock->stock = $stock->stock + $diff;
        } else if ($quantity < $quantityNow) {
            $diff = $quantityNow - $quantity;

            $stock->stock = $stock->stock - $diff;
        } else {
            $stock->stock = $stock->stock - 0;
        }

        $stock->save();

        // update query
        $receive_product->user_id = Auth::user()->employee_id;
        $receive_product->product_id = $request->product_id;
        $receive_product->price = $product->product_price_selling;
        $receive_product->quantity = $request->quantity;
        $receive_product->sub_total = $request->quantity * $product->product_price_selling;
        $receive_product->stock = $request->quantity;
        $receive_product->date = date('Y-m-d H:i:s');
        $receive_product->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $received_product = ReceiveProduct::find($id);

        return response()->json([
            'id' => $received_product->id,
            'product_name' => $received_product->product->product_name
        ]);
    }

    public function delete(Request $request)
    {
        $received_product = ReceiveProduct::find($request->id);

        // update stock
        $stock = ProductShop::where('product_id', $received_product->product_id)->first();
        $stock->stock = $stock->stock - $received_product->quantity;
        $stock->save();

        $received_product->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
