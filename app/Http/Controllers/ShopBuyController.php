<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopBuyController extends Controller
{
    public function index() {
        return view('pages.shop_buy.index');
    }

    public function store(Request $request)
    {

    }
}
