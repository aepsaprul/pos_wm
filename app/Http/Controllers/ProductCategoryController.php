<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_category = ProductCategory::get();

        return view('pages.product_category.index', ['product_categories' => $product_category]);
    }

    public function store(Request $request)
    {
        $product_category = new ProductCategory;
        $product_category->category_name = $request->category_name;
        $product_category->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $product_category = ProductCategory::find($id);

        return response()->json([
            'category_id' => $product_category->id,
            'category_name' => $product_category->category_name,
        ]);
    }

    public function update(Request $request)
    {
        $product_category = ProductCategory::find($request->id);
        $product_category->category_name = $request->category_name;
        $product_category->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $product_category = ProductCategory::find($id);

        return response()->json([
            'id' => $product_category->id,
            'category_name' => $product_category->category_name
        ]);
    }

    public function delete(Request $request)
    {
        $product_category = ProductCategory::find($request->id);
        $product_category->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
