<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductShop;
use App\Models\Promo;
use App\Models\ReceiveProduct;
use App\Models\Sales;
use App\Models\ShopStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CashierController extends Controller
{
    public function index()
    {
        if (Auth::user()->employee) {
            $invoice_number = Str::random(10);

            $sales = Sales::with('product')->where('user_id', Auth::user()->id)->where('invoice_id', null)->get();
            $total_price = $sales->sum('sub_total');

            $product_manual = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->get();
            $customer = Customer::where('shop_id', Auth::user()->employee->shop_id)->get();

            return view('pages.cashier.index', [
                'sales' => $sales,
                'total_price' => $total_price,
                'invoice_number' => $invoice_number,
                'product_manuals' => $product_manual,
                'customers' => $customer
            ]);
        } else {
            return view('page_403');
        }

    }

    public function getProduct(Request $request)
    {
        $product = Product::where('product_code', $request->product_code)
            ->orWhere('id', $request->product_manual)
            ->first();
        $stock = ProductShop::where('product_id', $product->id)
            ->where('shop_id', Auth::user()->employee->shop_id)
            ->first();

        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'stock' => $stock->stock,
            'product_price' => $product->product_price_selling
        ]);
    }

    public function salesSave(Request $request)
    {
        $sales_qty = Sales::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->where('invoice_id', null)
            ->first();

        if ($sales_qty) {
            $sales_qty->quantity = $sales_qty->quantity + $request->quantity;
            $sales_qty->sub_total = $sales_qty->sub_total + $request->sub_total;
            $sales_qty->save();
        } else {
            $sales = new Sales;
            $sales->user_id = Auth::user()->id;
            $sales->shop_id = Auth::user()->employee->shop_id;
            $sales->product_id = $request->product_id;
            $sales->quantity = $request->quantity;
            $sales->sub_total = $request->sub_total;
            $sales->save();
        }

        // update stock
        $received_product_stock = ReceiveProduct::where('product_id', $request->product_id)
            ->whereNotNull('stock')
            ->where('stock', '>', 0)
            ->select(DB::raw('sum(stock) as total_stock'))
            ->first();

        $stock_all = $received_product_stock->total_stock;
        $qty = $request->quantity;

        $received_product = ReceiveProduct::where('product_id', $request->product_id)
            ->whereNotNull('stock')
            ->where('stock', '>', 0)
            ->get();

        if ($qty <= $stock_all) {
            foreach ($received_product as $key => $item) {
                $id = $item->id;
                $stock = $item->stock;

                if ($qty > 0) {
                    $temp = $qty;
                    $qty = $qty - $stock;

                    if ($qty > 0) {
                        $stock_update = 0;
                    } else {
                        $stock_update = $stock - $temp;
                    }

                    $received_product_update = ReceiveProduct::where('product_id', $request->product_id)->where('id', $id)->first();
                    $received_product_update->stock = $stock_update;
                    $received_product_update->save();
                }
            }
        } else {
            echo "stok barang tidak cukup";
        }


        $stock = ProductShop::where('product_id', $request->product_id)->first();
        $stock->stock = $stock->stock - $request->quantity;
        $stock->save();

        return response()->json([
            'status' => "data berhasil ditambahkan"
        ]);
    }

    public function delete($id)
    {
        $sales = Sales::find($id);

        // update stock
        $stock = ShopStock::where('product_id', $sales->product_id)->first();
        $stock->stock = $stock->stock + $sales->quantity;
        $stock->save();

        $sales->delete();


        return redirect()->route('cashier.index');
    }

    public function print(Request $request)
    {
        $invoice_code = Str::random(10);

        $invoice = new Invoice;

        if ($request->customer_id) {
            $invoice->customer_id = $request->customer_id;
            $invoice->discount = $request->discount;
        }
        if ($request->promo) {
            $invoice->promo = $request->promo;
            $invoice->coupon_code = $request->coupon_code;
        }

        $invoice->bid = $request->bid;
        $invoice->total_amount = $request->total_amount;
        $invoice->date_recorded = date('Y-m-d H:i:s');
        $invoice->user_id = Auth::user()->id;
        $invoice->shop_id = Auth::user()->employee->shop_id;
        $invoice->code = $invoice_code;
        $invoice->save();

        $sales = Sales::where('user_id', Auth::user()->id)->where('invoice_id', null)->update(['invoice_id' => $invoice->id]);

        $sales_query = Sales::where('invoice_id', $invoice->id)->get();

        return response()->json([
            'invoice_code' => $invoice_code,
            'invoice_date' => date('d-m-Y', strtotime($invoice->date_recorded)),
            'invoice_time' => date('H:i:s', strtotime($invoice->date_recorded)),
            'sales' => $sales_query
        ]);
    }

    public function credit()
    {
        if (Auth::user()->employee) {
            $invoice_number = Str::random(10);

            $sales = Sales::with('product')->where('user_id', Auth::user()->id)->where('invoice_id', null)->get();
            $total_price = $sales->sum('sub_total');

            $product_manual = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->get();
            $customer = Customer::where('shop_id', Auth::user()->employee->shop_id)->get();

            return view('pages.cashier.credit', [
                'sales' => $sales,
                'total_price' => $total_price,
                'invoice_number' => $invoice_number,
                'product_manuals' => $product_manual,
                'customers' => $customer
            ]);
        } else {
            return view('page_403');
        }

    }

    public function promo(Request $request)
    {
        $promo = Promo::where('pay_method', $request->pay_method)
            ->where('publish', 'y')
            ->first();

        return response()->json([
            'promo' => $promo
        ]);
    }
}
