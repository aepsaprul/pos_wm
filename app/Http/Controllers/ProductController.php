<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['productMaster', 'category'])
            ->select(DB::raw('max(product_category_id) as product_category_id'), 'product_master_id')
            ->groupBy('product_master_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.product.index', ['products' => $product]);
    }

    public function create()
    {
        $category = ProductCategory::get();
        $product_master = ProductMaster::doesntHave('product')->get();

        $product = Product::max('id');
        $code = sprintf("%05s", $product + 1);

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master,
            'product_code' => $code
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'product_code.required' => 'Kode produk harus diisi',
            'category_id.required' => 'Kategori harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'gambar.required' => 'Gambar harus diisi',
            'gambar.image' => 'Gambar harus diisi dengan tipe gambar',
            'gambar.mimes' => 'Gambar harus diisi dengan format jpg/jpeg/png',
            'gambar.max' => 'Gambar maksimal 2 Mb'
        ];

        $validator = Validator::make($request->all(), [
            'product_code' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ], $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        } else {
            // $price = str_replace(".", "", $request->product_price);
            // $price_selling = str_replace(".", "", $request->product_price_selling);

            // $product = new Product;
            // $product->product_code = $request->product_code;
            // $product->product_name = $request->product_name;
            // $product->product_category_id = $request->category_id;
            // $product->product_price = $price;
            // $product->product_price_selling = $price_selling;
            // $product->weight = $request->weight;
            // $product->unit = $request->unit;
            // $product->description = $request->description;
            // $product->video = $request->video;

            // if($request->hasFile('image')) {
            //     $file = $request->file('image');
            //     $extension = $file->getClientOriginalExtension();
            //     $filename = time() . "." . $extension;
            //     $file->move('public/image/', $filename);
            //     $product->image = $filename;
            // }

            // $product->save();

            // if ($request->parameter_name) {
                // foreach ($request->parameter_name as $key => $value) {
                //     $product = new Product;
                //     $product->product_code = $request->product_code;
                //     $product->product_name = $request->product_name;
                //     $product->product_category_id = $request->category_id;
                //     $product->weight = $request->weight;
                //     $product->unit = $request->unit;
                //     $product->description = $request->description;
                //     $product->video = $request->video;

                    // if($request->hasFile('image')) {
                    //     $file = $request->file('image');
                    //     $extension = $file->getClientOriginalExtension();
                    //     $filename = time() . "." . $extension;
                    //     $file->move('public/image/', $filename);
                    //     $product->image = $filename;
                    // }

                //     $product->save();
                // }
            //     return response()->json([
            //         'status' => "if"
            //     ]);
            // } else {
                // $product = new Product;
                // $product->product_code = $request->product_code;
                // $product->product_name = $request->product_name;
                // $product->product_category_id = $request->category_id;
                // $product->weight = $request->weight;
                // $product->unit = $request->unit;
                // $product->description = $request->description;
                // $product->video = $request->video;

                // if($request->hasFile('image')) {
                //     $file = $request->file('image');
                //     $extension = $file->getClientOriginalExtension();
                //     $filename = time() . "." . $extension;
                //     $file->move('public/image/', $filename);
                //     $product->image = $filename;
                // }

                // $product->save();
            //     return response()->json([
            //         'status' => "else"
            //     ]);
            // }
            // return response()->json([
            //     'status' => $request->all()
            // ]);
        // }


            if ($request->parameter_name) {
                foreach ($request->parameter_name as $key => $value) {
                    $product_group = Product::where('product_master_id', $request->product_master)->get();
                    $count_product_group = count($product_group);

                    // insert data product
                    $product = new Product;
                    $product->product_master_id = $request->product_master;
                    $product->product_code = $request->product_code . $count_product_group;
                    $product->product_name = $value;
                    $product->weight = $request->parameter_weight[$key];
                    $product->unit = $request->parameter_unit[$key];
                    $product->save();
                }

                // insert data product master
                $product_master = ProductMaster::find($request->product_master);
                $product_master->code = $request->product_code;
                $product_master->product_category_id = $request->category_id;
                $product_master->description = $request->description;
                $product_master->video = $request->video;

                if($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . "." . $extension;
                    $file->move('public/image/', $filename);
                    $product_master->image = $filename;
                }

                $product_master->save();

                return response()->json([
                    'status' => $request->all()
                ]);
            } else {
                $product_group = Product::where('product_master_id', $request->product_master)->get();
                $count_product_group = count($product_group);

                // insert data product master
                $product_master = ProductMaster::find($request->product_master);
                $product_master->code = $request->product_code;
                $product_master->product_category_id = $request->category_id;
                $product_master->description = $request->description;
                $product_master->video = $request->video;

                if($request->hasFile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . "." . $extension;
                    $file->move('public/image/', $filename);
                    $product_master->image = $filename;
                }

                $product_master->save();

                // insert data product
                $product = new Product;
                $product->product_master_id = $request->product_master;
                $product->product_code = $request->product_code . $count_product_group;
                $product->product_name = $product_master->name;
                $product->weight = $request->weight;
                $product->unit = $request->unit;
                $product->save();

                return response()->json([
                    'status' => "tes"
                ]);
            }
        }
    }

    public function show($id)
    {
        $product = ProductMaster::with(['product', 'productCategory'])->find($id);
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

    public function productMasterStore(Request $request)
    {
        $product_master = new ProductMaster;
        $product_master->name = $request->product_master_name;
        $product_master->save();

        $category = ProductCategory::get();
        $product_master = ProductMaster::get();

        $product = Product::max('id');
        $code = sprintf("%05s", $product + 1);

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master,
            'product_code' => $code
        ]);
    }

    public function productCategoryStore(Request $request)
    {
        $product_category = new ProductCategory;
        $product_category->category_name = $request->product_category_name;
        $product_category->save();

        $category = ProductCategory::get();
        $product_master = ProductMaster::get();

        $product = Product::max('id');
        $code = sprintf("%05s", $product + 1);

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master,
            'product_code' => $code
        ]);
    }
}
