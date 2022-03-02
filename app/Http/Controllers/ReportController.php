<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductShop;
use App\Models\Sales;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $shop = Shop::get();

        return view('pages.report.index', ['shops' => $shop]);
    }

    public function salesShop($id)
    {
        $cashier = Employee::where('shop_id', $id)->where('position_id', 6)->get();

        return response()->json([
            'cashiers' => $cashier
        ]);
    }

    public function salesSearch(Request $request)
    {
        $shop_id = $request->shop_id;
        $opsi = $request->opsi;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->cashier_id != 0) {
            $cashier_id = $request->cashier_id;
            $user = User::where('employee_id', $cashier_id)->first();
        } else {
            $cashier_id = false;
            $user = false;
        }

        if ($opsi == 2) {
            $invoice = Invoice::with(['customer', 'user'])
                ->whereBetween('date_recorded', [$start_date, $end_date])
                ->where('shop_id', $shop_id)
                ->when($cashier_id, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->whereNull('customer_id')
                ->orderBy('id', 'desc')
                ->get();
        } elseif ($opsi == 3) {
            $invoice = Invoice::with(['customer', 'user'])
                ->whereBetween('date_recorded', [$start_date, $end_date])
                ->where('shop_id', $shop_id)
                ->when($cashier_id, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->whereNotNull('customer_id')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $invoice = Invoice::with(['customer', 'user'])
                ->whereBetween('date_recorded', [$start_date, $end_date])
                ->where('shop_id', $shop_id)
                ->when($cashier_id, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return response()->json([
            'invoices' => $invoice
        ]);

    }

    public function salesGetDataCurrent()
    {
        $invoice = Invoice::with(['customer', 'user'])->orderBy('id', 'desc')->get();

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function salesGetData(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($start_date == null || $end_date == null) {
            $invoice = Invoice::with(['customer', 'user'])
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $invoice = Invoice::with(['customer', 'user'])
                ->whereBetween('date_recorded', [$start_date, $end_date])
                ->orderBy('id', 'desc')
                ->get();
        }

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function salesNotCustomer(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $invoice = Invoice::with('user')
            ->whereNull('customer_id')
            ->whereBetween('date_recorded', [$start_date, $end_date])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function salesCustomer(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $invoice = Invoice::with(['customer', 'user'])
            ->whereNotNull('customer_id')
            ->whereBetween('date_recorded', [$start_date, $end_date])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function customerIndex()
    {
        $customer = Customer::get();

        return view('pages.report.customer', ['customers' => $customer]);
    }

    public function customerGetData()
    {
        $invoice = Invoice::with(['customer', 'user'])
            ->select(DB::raw('count(*) as transactions, customer_id'))
            ->whereNotNull('customer_id')
            ->groupBy('customer_id')
            ->orderBy('transactions', 'desc')
            ->get();

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function customerDetail($id)
    {
        $invoice = Invoice::with(['customer', 'user'])->where('customer_id', $id)->get();

        return response()->json([
            'invoices' => $invoice
        ]);
    }

    public function productIndex()
    {
        $produk_shop = ProductShop::with('product')->get();

        return view('pages.report.product', ['product_shops' => $produk_shop]);
    }

    public function productGetData()
    {
        $sales = Sales::with(['user', 'invoice', 'product'])
            ->select(DB::raw('count(*) as sold, product_id, sum(quantity) as qty, sum(sub_total) as sub_total'))
            ->groupBy('product_id')
            ->orderBy('sold', 'desc')
            ->get();

        return response()->json([
            'sales' => $sales
        ]);
    }

    public function productDetail($id)
    {
        $sales = Sales::with(['user', 'invoice', 'product'])
            ->where('product_id', $id)
            ->get();

        return response()->json([
            'sales' => $sales
        ]);
    }

    public function incomeIndex()
    {
        return view('pages.report.income');
    }

    public function incomeGetData()
    {
        $sales = Sales::with(['product', 'invoice'])->orderBy('id', 'desc')->get();

        return response()->json([
            'sales' => $sales
        ]);
    }

    public function incomeFilter(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sales = Sales::with(['invoice', 'product'])->whereHas('invoice', function ($query) use ($start_date, $end_date) {
            $query->whereBetween('date_recorded', [$start_date, $end_date]);
        })->get();

        return response()->json([
            'sales' => $sales,
            'start_date' => $request->start_date,
            'end_date' => $end_date
        ]);
    }
}
