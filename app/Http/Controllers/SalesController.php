<?php

namespace App\Http\Controllers;

use App\Models\CreditPayment;
use App\Models\Invoice;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function index()
    {
        $invoice = Invoice::where('shop_id', Auth::user()->employee->shop_id)->orderBy('id', 'desc')->get();
        return view('pages.sales.index', ['invoices' => $invoice]);
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        $sales = Sales::where('invoice_id', $invoice->id)->get();

        return view('pages.sales.show', ['invoice' => $invoice, 'sales' => $sales]);
    }

    public function deleteBtn($id)
    {
        $invoice = Invoice::find($id);

        return response()->json([
            'id' => $invoice->id,
            'code' => $invoice->code
        ]);
    }

    public function delete(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->delete();

        $sales = Sales::where('invoice_id', $invoice->id);
        $sales->delete();

        $credit = CreditPayment::where('invoice_id', $invoice->id);
        $credit->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
