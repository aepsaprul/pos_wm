<?php

namespace App\Http\Controllers;

use App\Models\InventoryInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopTransaksiController extends Controller
{
  public function index()
  {
    $transaksi = InventoryInvoice::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

    return view('pages.shop_transaksi.index', ['transaksis' => $transaksi]);
  }
}
