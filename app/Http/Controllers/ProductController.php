<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::get();

        return view('pages.product.index', ['products' => $product]);
    }

    public function create()
    {
        $category = ProductCategory::get();

        $product = Product::max('id');
        $code = sprintf("%07s", $product + 1);

        return response()->json([
            'categories' => $category,
            'product_code' => $code
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->product_code = $request->product_code;
        $product->product_name = $request->product_name;
        $product->product_category_id = $request->product_category_id;
        $product->product_price = $request->product_price;
        $product->product_price_selling = $request->product_price_selling;
        $product->stock = $request->stock;
        $product->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = ProductCategory::get();

        if ($product->product_price == null) {
            $product_price = 0;
        } else {
            $product_price = $product->product_price;
        }

        if ($product->product_price_selling == null) {
            $product_price_selling = 0;
        } else {
            $product_price_selling = $product->product_price_selling;
        }

        return response()->json([
            'product_id' => $product->id,
            'product_code' => $product->product_code,
            'product_name' => $product->product_name,
            'product_category_id' => $product->product_category_id,
            'product_price' => $product_price,
            'product_price_selling' => $product_price_selling,
            'stock' => $product->stock,
            'categories' => $category
        ]);
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $product->product_code = $request->product_code;
        $product->product_name = $request->product_name;
        $product->product_category_id = $request->product_category_id;
        $product->product_price = $request->product_price;
        $product->product_price_selling = $request->product_price_selling;
        $product->stock = $request->stock;
        $product->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $product = Product::find($id);

        return response()->json([
            'id' => $product->id,
            'product_name' => $product->product_name
        ]);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $product->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
