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
            ->select(DB::raw('max(product_category_id) as product_category_id'), DB::raw('sum(stock) as total_stock'), 'product_master_id')
            ->groupBy('product_master_id')
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.product.index', ['products' => $product]);
    }

    public function create()
    {
        $category = ProductCategory::get();
        $product_master = ProductMaster::doesntHave('product')->get();

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master
        ]);
    }

    public function store(Request $request)
    {
        $messages = [
            'category_id.required' => 'Kategori harus diisi',
            'description.required' => 'Deskripsi harus diisi',
            'gambar.required' => 'Gambar harus diisi',
            'gambar.image' => 'Gambar harus diisi dengan tipe gambar',
            'gambar.mimes' => 'Gambar harus diisi dengan format jpg/jpeg/png',
            'gambar.max' => 'Gambar maksimal 2 Mb'
        ];

        $validator = Validator::make($request->all(), [
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
                // update data product master
                $product_master = ProductMaster::find($request->product_master);
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

                foreach ($request->parameter_name as $key => $value) {
                    $product_group = Product::where('product_master_id', $request->product_master)->get();
                    $count_product_group = count($product_group) + 1;

                    // insert data product
                    $product = new Product;
                    $product->product_master_id = $request->product_master;
                    $product->product_code = $product_master->code . $count_product_group;
                    $product->product_name = $value;
                    $product->weight = $request->parameter_weight[$key];
                    $product->unit = $request->parameter_unit[$key];
                    $product->save();
                }
            } else {
                $product_group = Product::where('product_master_id', $request->product_master)->get();
                $count_product_group = count($product_group) + 1;

                // update data product master
                $product_master = ProductMaster::find($request->product_master);
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
                $product->product_code = $product_master->code . $count_product_group;
                $product->product_name = $product_master->name;
                $product->weight = $request->weight;
                $product->unit = $request->unit;
                $product->save();
            }

            return response()->json([
                'status' => 'true'
            ]);
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
        $product = ProductMaster::with(['product', 'productCategory'])->find($id);
        $category = ProductCategory::get();
        $product_master = ProductMaster::get();

        return response()->json([
            'product' => $product,
            'categories' => $category,
            'product_masters' => $product_master
        ]);
    }

    public function update(Request $request)
    {
        // update data product master
        $product_master = ProductMaster::find($request->edit_id);
        $product_master->product_category_id = $request->edit_category_id;
        $product_master->description = $request->edit_description;
        $product_master->video = $request->edit_video;

        if($request->hasFile('edit_image')) {
            $file = $request->file('edit_image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . "." . $extension;
            $file->move('public/image/', $filename);
            $product_master->image = $filename;
        }

        $product_master->save();

        // update product
        foreach ($request->parameter_id as $key => $value) {

            // insert data product
            $product = Product::find($value);
            $product->product_name = $request->parameter_name[$key];
            $product->weight = $request->parameter_weight[$key];
            $product->unit = $request->parameter_unit[$key];
            $product->product_price = $request->parameter_hpp[$key];
            $product->product_price_selling = $request->parameter_harga_jual[$key];
            $product->save();
        }

        // $product = Product::find($request->id);
        // $product->product_code = $request->product_code;
        // $product->product_name = $request->product_name;
        // $product->product_category_id = $request->category_id;
        // $product->weight = $request->weight;
        // $product->unit = $request->unit;
        // $product->description = $request->description;
        // $product->video = $request->video;

        // if($request->hasFile('image')) {
        //     if (file_exists("public/image/" . $product->image)) {
        //         File::delete("public/image/" . $product->image);
        //     }
        //     $file = $request->file('image');
        //     $extension = $file->getClientOriginalExtension();
        //     $filename = time() . "." . $extension;
        //     $file->move('public/image/', $filename);
        //     $product->image = $filename;
        // }

        // $product->save();

        return response()->json([
            'status' => $request->all()
        ]);
    }

    public function deleteBtn($id)
    {
        return response()->json([
            'id' => $id
        ]);
    }

    public function delete(Request $request)
    {
        $product = Product::where('product_master_id', $request->id);

        $product_master = ProductMaster::find($request->id);
        if (file_exists("public/image/" . $product_master->image)) {
            File::delete("public/image/" . $product_master->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }

    public function productMasterStore(Request $request)
    {
        $product = ProductMaster::max('id');
        $code = sprintf("%05s", $product + 1);

        $product_master = new ProductMaster;
        $product_master->code = $code;
        $product_master->name = $request->product_master_name;
        $product_master->save();

        $category = ProductCategory::get();
        $product_master = ProductMaster::doesntHave('product')->get();

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master
        ]);
    }

    public function productCategoryStore(Request $request)
    {
        $product_category = new ProductCategory;
        $product_category->category_name = $request->product_category_name;
        $product_category->save();

        $category = ProductCategory::get();
        $product_master = ProductMaster::doesntHave('product')->get();

        return response()->json([
            'categories' => $category,
            'product_masters' => $product_master
        ]);
    }

    public function remove($id)
    {
        $product = Product::find($id);
        $product->delete();

        $product_master = ProductMaster::with('product')->find($product->product_master_id);
        $products = Product::where('product_master_id', $product_master->id)->get();

        return response()->json([
            'status' => 'true',
            'products' => $products
        ]);
    }

    public function addParameter(Request $request)
    {
        $product_master = ProductMaster::find($request->edit_add_parameter_id);
        $product_group = Product::where('product_master_id', $request->edit_add_parameter_id)->get();
        $count_product_group = count($product_group) + 1;

        $product = new Product;
        $product->product_master_id = $request->edit_add_parameter_id;
        $product->product_code = $product_master->code . $count_product_group;
        $product->product_name = $request->edit_add_parameter_name;
        $product->weight = $request->edit_add_parameter_weight;
        $product->unit = $request->edit_add_parameter_unit;
        $product->save();

        // view data prdocut
        $product_master = ProductMaster::with('product')->find($request->edit_add_parameter_id);
        $products = Product::where('product_master_id', $product_master->id)->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function barcode($id)
    {
        $product = Product::with('productMaster')->where('product_master_id', $id)->get();

        return response()->json([
            'products' => $product
        ]);
    }

    public function barcodePrint(Request $request)
    {
        $product = Product::find($request->id);

        return response()->json([
            'product' => $product
        ]);
    }

    public function barcodePrintTemplate($id)
    {
        $product = Product::find($id);

        return view('pages.product.barcode', ['product' => $product]);
    }
}
