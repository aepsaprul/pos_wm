<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('id', 'desc')->get();

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
        $messages = [
            'product_code.required' => 'Kode produk harus diisi',
            'product_name.required' => 'Nama produk harus diisi',
            'category_id.required' => 'Kategori harus diisi',
            'product_price.required' => 'HPP harus diisi',
            'weight.required' => 'HPP harus diisi',
            'unit.required' => 'HPP harus diisi',
            'description.required' => 'HPP harus diisi',
            'gambar.required' => 'Gambar harus diisi',
            'gambar.image' => 'Gambar harus diisi dengan tipe gambar',
            'gambar.mimes' => 'Gambar harus diisi dengan format jpg/jpeg/png',
            'gambar.max' => 'Gambar maksimal 2 Mb'
        ];

        $validator = Validator::make($request->all(), [
            'product_code' => 'required',
            'product_name' => 'required',
            'category_id' => 'required',
            'product_price' => 'required',
            'product_price_selling' => 'required',
            'weight' => 'required',
            'unit' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {
            $price = str_replace(".", "", $request->product_price);
            $price_selling = str_replace(".", "", $request->product_price_selling);

            $product = new Product;
            $product->product_code = $request->product_code;
            $product->product_name = $request->product_name;
            $product->product_category_id = $request->category_id;
            $product->product_price = $price;
            $product->product_price_selling = $price_selling;
            $product->weight = $request->weight;
            $product->unit = $request->unit;
            $product->description = $request->description;
            $product->video = $request->video;

            if($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . "." . $extension;
                $file->move('public/image/', $filename);
                $product->image = $filename;
            }

            $product->save();

            return response()->json([
                'status' => 'Data berhasil di simpan'
            ]);
        }
    }

    public function show($id)
    {
        $product = Product::find($id);
        $category = ProductCategory::get();

        return response()->json([
            'product' => $product,
            'categories' => $category
        ]);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = ProductCategory::get();

        return response()->json([
            'product' => $product,
            'categories' => $category
        ]);
    }

    public function update(Request $request)
    {
        $price = str_replace(".", "", $request->product_price);
        $price_selling = str_replace(".", "", $request->product_price_selling);

        $product = Product::find($request->id);
        $product->product_code = $request->product_code;
        $product->product_name = $request->product_name;
        $product->product_category_id = $request->category_id;
        $product->product_price = $price;
        $product->product_price_selling = $price_selling;
        $product->weight = $request->weight;
        $product->unit = $request->unit;
        $product->description = $request->description;
        $product->video = $request->video;

        if($request->hasFile('image')) {
            if (file_exists("public/image/" . $product->image)) {
                File::delete("public/image/" . $product->image);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('public/image/', $filename);
            $product->image = $filename;
        }

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

        if (file_exists("public/image/" . $product->image)) {
            File::delete("public/image/" . $product->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
