<?php

namespace App\Http\Controllers;

use App\Models\CreditPayment;
use App\Models\Invoice;
use App\Models\NavigasiAccess;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $tanggal_sekarang = date("Y-m-d");

        if (Auth::user()->employee) {
            $invoice = Invoice::where('shop_id', Auth::user()->employee->shop_id)->limit('900')->orderBy('id', 'desc')->get();
            $invoice_hari_ini = Invoice::select(DB::raw('SUM(total_amount) AS total_hari_ini'))
                ->where('created_at', 'like', '%' . $tanggal_sekarang . '%')
                ->first();

            $navigasi = NavigasiAccess::with('navigasiButton')
                ->whereHas('navigasiButton.navigasiSub', function ($query) {
                    $query->where('aktif', 'shop_transaction/invoice');
                })
                ->where('karyawan_id', Auth::user()->employee_id)->get();

            $data_navigasi = [];
            foreach ($navigasi as $key => $value) {
                $data_navigasi[] = $value->navigasiButton->title;
            }

            return view('pages.invoice.index', [
                'invoices' => $invoice,
                'data_navigasi' => $data_navigasi,
                'total_hari_ini' => $invoice_hari_ini->total_hari_ini
            ]);
        } else {
            return view('page_403');
        }
    }

    public function show($id)
    {
        $invoice = Invoice::find($id);
        $sales = Sales::with('product')->where('invoice_id', $invoice->id)->get();
        $credit = CreditPayment::with('customer')->where('invoice_id', $invoice->id)->get();
        $count_credit = count($credit);

        return response()->json([
            'code' => $invoice->code,
            'date' => date('d-m-Y', strtotime($invoice->date_recorded)),
            'total_amount' => $invoice->total_amount,
            'sales' => $sales,
            'credits' => $credit,
            'count_credits' => $count_credit
        ]);
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

    public function bayar($id)
    {
        $invoice = Invoice::with('customer')->find($id);
        $credit = CreditPayment::where('invoice_id', $invoice->id)->where('pay_date', null)->first();

        return response()->json([
            'invoice' => $invoice,
            'credit' => $credit
        ]);
    }

    public function bayarSave(Request $request)
    {
        $credit = CreditPayment::find($request->id);

        $invoice = Invoice::find($credit->invoice_id);
        $debt = $invoice->debt - $request->price; // update debt
        $invoice->debt = $debt;
        $invoice->save();

        $credit->pay_date = date('Y-m-d H:i:s');
        $credit->price = $request->price;
        $credit->debt = $debt;
        $credit->save();

        return response()->json([
            'status' => $debt
        ]);
    }

    public function penjualanHariIni()
    {
        $hari_ini = date("Y-m-d");

        if (Auth::user()->employee) {
          $invoice = Invoice::where('shop_id', Auth::user()->employee->shop_id)->where('created_at', 'like', '%' . $hari_ini . '%')->get();
          $invoice_hari_ini = Invoice::select(DB::raw('SUM(total_amount) AS total_hari_ini'))
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->where('created_at', 'like', '%' . $hari_ini . '%')
            ->first();
        } else {
          $invoice = Invoice::where('created_at', 'like', '%' . $hari_ini . '%')->get();
          $invoice_hari_ini = Invoice::select(DB::raw('SUM(total_amount) AS total_hari_ini'))
            ->where('created_at', 'like', '%' . $hari_ini . '%')
            ->first();
        }

        return view('pages.invoice.penjualanHariIni', [
            'invoices' => $invoice,
            'total_hari_ini' => $invoice_hari_ini->total_hari_ini
        ]);
    }
}
