<?php

namespace App\Http\Controllers;

use App\Models\InventoryInvoice;
use App\Models\InventoryProductOut;
use App\Models\Notif;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryInvoiceController extends Controller
{
    public function index()
    {
        $invoice = InventoryInvoice::with([
            'productOut' => function ($qry) {
                $qry->select(['invoice_id', app('db')->raw('sum(quantity) AS qty')])->groupBy('invoice_id');
            }])
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.inventory_invoice.index', ['invoices' => $invoice]);
    }

    public function show($id)
    {
        $invoice = InventoryInvoice::find($id);
        $inventory_product_out = InventoryProductOut::with('product')->where('invoice_id', $invoice->id)->get();

        return response()->json([
            'code' => $invoice->code,
            'date' => date('d-m-Y', strtotime($invoice->date_recorded)),
            'total_amount' => $invoice->total_amount,
            'inventory_product_outs' => $inventory_product_out
        ]);
    }

    public function deleteBtn($id)
    {
        $invoice = InventoryInvoice::find($id);

        return response()->json([
            'id' => $invoice->id,
            'code' => $invoice->code
        ]);
    }

    public function delete(Request $request)
    {
        $invoice = InventoryInvoice::find($request->id);
        $invoice->delete();

        $inventory_product_out = InventoryProductOut::where('invoice_id', $invoice->id);
        $inventory_product_out->delete();

        $notif = Notif::where('invoice_id', $request->id);
        $notif->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }

    public function print($id)
    {
        $shop = Shop::find(Auth::user()->employee->shop_id);
        $invoice = InventoryInvoice::find($id);
        $product_outs = InventoryProductOut::where('invoice_id', $id)->get();

        // return view('pages.inventory_invoice.print', [
        //     'shop' => $shop,
        //     'invoice' => $invoice,
        //     'product_outs' => $product_outs
        // ]);

        $pdf = Pdf::loadView('pages.inventory_invoice.print', ['shop' => $shop, 'invoice' => $invoice, 'product_outs' => $product_outs]);

        return $pdf->stream();
    }

    public function unpaid($id)
    {
        $invoice = InventoryInvoice::find($id);
        $invoice->status = "paid";
        $invoice->save();

        $notif = Notif::where('invoice_id', $id)->first();
        if ($notif) {
            $notif->status = "finish";
            $notif->save();
        }

        return response()->json([
            'status' => 200
        ]);
    }

    public function cancel($id)
    {
        $invoice = InventoryInvoice::find($id);
        $invoice->status = "cancel";
        $invoice->save();

        $notif = Notif::where('invoice_id', $id)->first();
        if ($notif) {
            $notif->status = "finish";
            $notif->save();
        }

        return response()->json([
            'status' => 200
        ]);
    }
}
