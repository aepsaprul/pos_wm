<?php

namespace App\Http\Controllers;

use App\Models\NavigasiAccess;
use App\Models\Product;
use App\Models\ProductShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductShopController extends Controller
{
    public function index()
    {
        if (Auth::user()->employee) {
            $product_shop = ProductShop::where('shop_id', Auth::user()->employee->shop->id)->orderBy('id', 'desc')->get();

            $navigasi = NavigasiAccess::with('navigasiButton')
                ->whereHas('navigasiButton.navigasiSub', function ($query) {
                    $query->where('aktif', 'product_shop');
                })
                ->where('karyawan_id', Auth::user()->employee_id)->get();

            $data_navigasi = [];
            foreach ($navigasi as $key => $value) {
                $data_navigasi[] = $value->navigasiButton->title;
            }

            return view('pages.product_shop.index', [
                'product_shops' => $product_shop,
                'data_navigasi' => $data_navigasi
            ]);
        } else {
            return view('page_403');
        }
    }

    public function create()
    {
        $product = Product::with('productMaster')->get();

        return response()->json([
            'products' => $product
        ]);
    }

    public function store(Request $request)
    {
        $product_shop_check = ProductShop::where('product_id', $request->product_id)
            ->where('shop_id', Auth::user()->employee->shop->id)
            ->first();

        if ($product_shop_check) {
            return response()->json([
                'status' => 'false'
            ]);
        } else {
            $product_shop = new ProductShop;
            $product_shop->product_id = $request->product_id;

            if (Auth::user()->employee) {
                $product_shop->shop_id = Auth::user()->employee->shop->id;
            }

            $product_shop->save();

            return response()->json([
                'status' => 'true'
            ]);
        }
    }

    public function edit($id)
    {
        $product_shop = ProductShop::find($id);
        $product = Product::get();

        return response()->json([
            'id' => $product_shop->id,
            'product_id' => $product_shop->product_id,
            'products' => $product
        ]);
    }

    public function update(Request $request)
    {
        $product_shop_check = ProductShop::where('product_id', $request->product_id)
            ->where('shop_id', Auth::user()->employee->shop->id)
            ->first();

        if ($product_shop_check) {
            return response()->json([
                'status' => 'false'
            ]);
        } else {
            $product_shop = ProductShop::find($request->id);
            $product_shop->product_id = $request->product_id;
            $product_shop->save();

            $product = Product::find($request->product_id);

            return response()->json([
                'status' => 'true',
                'id' => $request->id,
                'product_name' => $product->product_name,
                'category_name' => $product->category->category_name,
                'code' => $product->product_code,
                'price' => $product->product_price,
                'price_selling' => $product->product_price_selling
            ]);
        }
    }

    public function deleteBtn($id)
    {
        $product_shop = ProductShop::find($id);


        return response()->json([
            'id' => $product_shop->id
        ]);
    }

    public function delete(Request $request)
    {
        $product_shop = ProductShop::find($request->id);
        $product_shop->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
