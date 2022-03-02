<?php

namespace App\Http\Controllers;

use App\Models\InventoryProductOut;
use App\Models\InventoryStock;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventroryProductOutController extends Controller
{
    public function index()
    {
        $productOut = InventoryProductOut::get();

        return view('pages.inventory_product_out.index', ['product_outs' => $productOut]);
    }

    public function create()
    {
        $product = Product::get();

        if (Auth::user()->employee) {
            $shop = Shop::where('id', '!=', Auth::user()->employee->shop->id)->get();
        } else {
            $shop = Shop::get();
        }

        return response()->json([
            'products' => $product,
            'shops' => $shop
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)->first();

        $productOut = new InventoryProductOut;
        $productOut->product_id = $request->product_id;
        $productOut->shop_id = $request->shop_id;
        $productOut->price = $product->product_price_selling;
        $productOut->quantity = $request->quantity;
        $productOut->sub_total = $product->product_price_selling * $request->quantity;
        $productOut->date = date('Y-m-d H:i:s');
        $productOut->user_id = Auth::user()->id;
        $productOut->save();

        $stock = InventoryStock::where('product_id', $request->product_id)->first();
        $stock->stock = $stock->stock - $request->quantity;
        $stock->save();

        return response()->json([
            'status' => "Data berhasil disimpan"
        ]);
    }

    public function edit($id)
    {
        $productOut = InventoryProductOut::find($id);
        $product = Product::get();
        $shop = Shop::get();

        return response()->json([
            'id' => $productOut->id,
            'product_id' => $productOut->product_id,
            'shop_id' => $productOut->shop_id,
            'quantity' => $productOut->quantity,
            'products' => $product,
            'shops' => $shop
        ]);
    }

    public function update(Request $request)
    {
        $productOut = InventoryProductOut::find($request->id);
        $product = Product::where('id', $request->product_id)->first();

        // update stock
        $quantity = $request->quantity;
        $quantityNow = $productOut->quantity;

        $stock = InventoryStock::where('product_id', $request->product_id)->first();

        if ($quantity > $quantityNow) {
            $diff = $quantity - $quantityNow;

            $stock->stock = $stock->stock - $diff;
        } else if ($quantity < $quantityNow) {
            $diff = $quantityNow - $quantity;

            $stock->stock = $stock->stock + $diff;
        } else {
            $stock->stock = $stock->stock - 0;
        }

        $stock->save();

        // update query
        $productOut->product_id = $request->product_id;
        $productOut->shop_id = $request->shop_id;
        $productOut->price = $product->product_price_selling;
        $productOut->quantity = $request->quantity;
        $productOut->sub_total = $product->product_price_selling * $request->quantity;
        $productOut->user_id = Auth::user()->id;
        $productOut->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $productOut = InventoryProductOut::find($id);

        return response()->json([
            'id' => $productOut->id,
            'name' => $productOut->product->name
        ]);
    }

    public function delete(Request $request)
    {
        $productOut = InventoryProductOut::find($request->id);

        // update stock
        $stock = InventoryStock::where('product_id', $productOut->product_id)->first();
        $stock->stock = $stock->stock + $productOut->quantity;
        $stock->save();

        $productOut->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
