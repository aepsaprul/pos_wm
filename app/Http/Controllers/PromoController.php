<?php

namespace App\Http\Controllers;

use App\Models\Promo;
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
        $promo->pay_method = $request->pay_method;
        $promo->discount_value = $request->discount_value;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimum_order = $request->minimum_order;
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
            'pay_method' => $promo->pay_method,
            'discount_value' => $promo->discount_value,
            'coupon_code' => $promo->coupon_code,
            'minimum_order' => $promo->minimum_order
        ]);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->promo_name = $request->promo_name;
        $promo->pay_method = $request->pay_method;
        $promo->discount_value = $request->discount_value;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimum_order = $request->minimum_order;
        $promo->publish = $request->publish;
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
}
