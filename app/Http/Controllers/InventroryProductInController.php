<?php

namespace App\Http\Controllers;

use App\Models\InventoryProductIn;
use App\Models\InventoryStock;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventroryProductInController extends Controller
{
    public function index()
    {
        $productIn = InventoryProductIn::orderBy('id', 'desc')->get();

        return view('pages.inventory_product_in.index', ['product_ins' => $productIn]);
    }

    public function create()
    {
        $product = Product::with('productMaster')->get();
        $supplier = Supplier::get();

        return response()->json([
            'products' => $product,
            'suppliers' => $supplier
        ]);
    }

    public function store(Request $request)
    {
        $productIn = new InventoryProductIn;
        $productIn->product_id = $request->product_id;
        $productIn->supplier_id = $request->supplier_id;
        $productIn->price = $request->price;
        $productIn->quantity = $request->quantity;
        $productIn->sub_total = $request->price * $request->quantity;
        $productIn->date = date('Y-m-d H:i:s');
        $productIn->user_id = Auth::user()->id;
        $productIn->stock = $request->quantity;
        $productIn->save();

        $stock = Product::where('id', $request->product_id)->first();
        $stock->stock = $stock->stock + $request->quantity;
        $stock->product_price = $request->price;
        $stock->save();

        return response()->json([
            'status' => "Data berhasil disimpan"
        ]);
    }

    public function edit($id)
    {
        $productIn = InventoryProductIn::find($id);
        $product = Product::get();
        $supplier = Supplier::get();

        return response()->json([
            'id' => $productIn->id,
            'product_id' => $productIn->product_id,
            'supplier_id' => $productIn->supplier_id,
            'price' => $productIn->price,
            'quantity' => $productIn->quantity,
            'products' => $product,
            'suppliers' => $supplier
        ]);
    }

    public function update(Request $request)
    {
        $productIn = InventoryProductIn::find($request->id);

        // update stock
        $quantity = $request->quantity;
        $quantityNow = $productIn->quantity;

        $stock = Product::find($request->product_id);

        if ($quantity > $quantityNow) {
            $diff = $quantity - $quantityNow;

            $stock->stock = $stock->stock + $diff;
        } else if ($quantity < $quantityNow) {
            $diff = $quantityNow - $quantity;

            $stock->stock = $stock->stock - $diff;
        } else {
            $stock->stock = $stock->stock - 0;
        }

        $stock->product_price = $request->price;
        $stock->save();

        // update query
        $productIn->product_id = $request->product_id;
        $productIn->supplier_id = $request->supplier_id;
        $productIn->price = $request->price;
        $productIn->quantity = $request->quantity;
        $productIn->sub_total = $request->price * $request->quantity;
        $productIn->user_id = Auth::user()->id;
        $productIn->stock = $request->quantity;
        $productIn->save();


        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $productIn = InventoryProductIn::find($id);

        return response()->json([
            'id' => $productIn->id,
            'name' => $productIn->product->name
        ]);
    }

    public function delete(Request $request)
    {
        $productIn = InventoryProductIn::find($request->id);

        // update stock
        $stock = Product::find($productIn->product_id);
        $stock->stock = $stock->stock - $productIn->quantity;
        $stock->save();

        $productIn->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
