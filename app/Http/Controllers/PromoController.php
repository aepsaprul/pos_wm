<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promo;
use App\Models\PromoProduct;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promo = Promo::get();

        return view('pages.promo.index', ['promos' => $promo]);
    }

    public function store(Request $request)
    {
        $promo = new Promo;
        $promo->promo_name = $request->promo_name;
        $promo->promo_method = $request->promo_method;
        $promo->pay_method = $request->pay_method;
        $promo->discount_value = $request->discount_value;
        $promo->discount_percent = $request->discount_percent;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimum_order = $request->minimum_order;
        $promo->minimum_order_qty = $request->minimum_order_qty;
        $promo->publish = $request->publish;
        $promo->save();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function edit($id)
    {
        $promo = Promo::find($id);

        return response()->json([
            'id' => $promo->id,
            'promo_name' => $promo->promo_name,
            'promo_method' => $promo->promo_method,
            'pay_method' => $promo->pay_method,
            'discount_value' => $promo->discount_value,
            'discount_percent' => $promo->discount_percent,
            'coupon_code' => $promo->coupon_code,
            'minimum_order' => $promo->minimum_order,
            'minimum_order_qty' => $promo->minimum_order_qty
        ]);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->promo_name = $request->promo_name;
        $promo->promo_method = $request->promo_method;
        $promo->pay_method = $request->pay_method;
        $promo->discount_value = $request->discount_value;
        $promo->discount_percent = $request->discount_percent;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimum_order = $request->minimum_order;
        $promo->minimum_order_qty = $request->minimum_order_qty;
        $promo->save();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function deleteBtn($id)
    {
        $promo = Promo::find($id);

        return response()->json([
            'id' => $promo->id,
            'promo_name' => $promo->promo_name
        ]);
    }

    public function delete(Request $request)
    {
        $promo = Promo::find($request->id);
        $promo->delete();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function publish(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->publish = $request->publish;
        $promo->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function addProduct($id)
    {
        $promo = Promo::find($id);
        $product = Product::with('productMaster')->get();
        $promo_product = PromoProduct::where('promo_id', $promo->id)->get();

        return view('pages.promo.add_product', ['promo' => $promo, 'products' => $product, 'promo_products' => $promo_product]);
    }

    public function addProductSave(Request $request)
    {
        $promo_product = new PromoProduct;
        $promo_product->promo_id = $request->promo_id;
        $promo_product->product_id = $request->product_id;
        $promo_product->save();

        return redirect()->route('promo.add_product', [$request->promo_id]);
    }

    public function deletePromoProduct($id) {
        $promo_product = PromoProduct::find($id);

        $id = $promo_product->promo_id;

        $promo_product->delete();

        return redirect()->route('promo.add_product', [$id]);
    }
}
