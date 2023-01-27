<?php

namespace App\Http\Controllers;

use App\Models\InventoryInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShopTransaksiController extends Controller
{
  public function index()
  {
    $transaksi = InventoryInvoice::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
    $total_belanja = InventoryInvoice::select(DB::raw("SUM(total_amount) as total_amount_"))->where('user_id', Auth::user()->id)->where('status_transaksi', '4')->first();

    return view('pages.shop_transaksi.index', [
      'transaksis' => $transaksi,
      'total_belanja' => $total_belanja
    ]);
  }

  public function dataTransaksi()
  {
    $transaksi = InventoryInvoice::with('statusTransaksi')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

    return response()->json([
      'transaksi' => $transaksi
    ]);
  }

  public function dataSearch(Request $request)
  {
    $start_date = $request->start_date . ' 00:00:00';
    $end_date = $request->end_date . ' 23:59:00';

    $transaksi = InventoryInvoice::with('statusTransaksi')
      ->where('user_id', Auth::user()->id)
      ->whereBetween('updated_at', [$start_date, $end_date])
      ->orderBy('id', 'desc')
      ->get();

    $total_belanja = InventoryInvoice::select(DB::raw("SUM(total_amount) as total_amount_"))
      ->where('user_id', Auth::user()->id)
      ->whereBetween('updated_at', [$start_date, $end_date])
      ->first();

    return response()->json([
      'transaksi' => $transaksi,
      'total_belanja' => $total_belanja
    ]);
  }
}
