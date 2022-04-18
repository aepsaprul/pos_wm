<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shop = Shop::get();

        return view('pages.shop.index', ['shops' => $shop]);
    }

    public function store(Request $request)
    {
        $shop = new Shop;
        $shop->name = $request->name;
        $shop->contact = $request->contact;
        $shop->email = $request->email;
        $shop->address = $request->address;
        $shop->category = $request->category;
        $shop->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $shop = Shop::find($id);

        return response()->json([
            'id' => $shop->id,
            'name' => $shop->name,
            'contact' => $shop->contact,
            'email' => $shop->email,
            'address' => $shop->address,
            'category' => $shop->category
        ]);
    }

    public function update(Request $request)
    {
        $shop = Shop::find($request->id);
        $shop->name = $request->name;
        $shop->contact = $request->contact;
        $shop->email = $request->email;
        $shop->address = $request->address;
        $shop->category = $request->category;
        $shop->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $shop = Shop::find($id);

        return response()->json([
            'id' => $shop->id,
            'name' => $shop->name
        ]);
    }

    public function delete(Request $request)
    {
        $shop = Shop::find($request->id);
        $shop->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
