<?php

namespace App\Http\Controllers;

use App\Models\InventoryInvoice;
use App\Models\ReceiveProduct;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
  public function index()
  {
    $transaction = InventoryInvoice::with('productOut')->where('shop_id', Auth::user()->employee->shop_id)
      ->where('status', "unpaid")
      ->get();

    return view('pages.transaction.index', ['transactions' => $transaction]);
  }
}
