<?php

namespace App\Http\Controllers;

use App\Models\CreditPayment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductShop;
use App\Models\Promo;
use App\Models\PromoProduct;
use App\Models\ReceiveProduct;
use App\Models\Sales;
use App\Models\Shop;
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

            $sales = Sales::with(['product', 'product.promo'])->where('user_id', Auth::user()->id)->where('invoice_id', null)->get();
            $total_price = $sales->sum('sub_total') + $sales->sum('promo_total');

            $product_manual = ProductShop::where('shop_id', Auth::user()->employee->shop_id)->get();
            $customer = Customer::where('shop_id', Auth::user()->employee->shop_id)->get();

            $promo = PromoProduct::with('promo')
                ->whereHas('promo', function ($query){
                    $query->where('promo_method', 'per_produk')->where('publish', 'y');
                })->get();

            return view('pages.cashier.index', [
                'sales' => $sales,
                'total_price' => $total_price,
                'invoice_number' => $invoice_number,
                'product_manuals' => $product_manual,
                'customers' => $customer,
                'promos' => $promo
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
        // update stock
        $received_product_stock = ReceiveProduct::where('product_id', $request->product_id)
            ->where('shop_id', Auth::user()->employee->shop_id)
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

            $product = Product::find($request->product_id);

            // cek promo per produk
            $promo = PromoProduct::with('promo')
                ->whereHas('promo', function ($query){
                    $query->where('promo_method', 'per_produk')->where('publish', 'y');
                })
                ->where('product_id', $request->product_id)
                ->first();

            $sales_qty = Sales::where('user_id', Auth::user()->id)
                ->where('product_id', $request->product_id)
                ->where('invoice_id', null)
                ->first();

            $discount = $product->product_price_selling * ($promo->promo->discount_percent / 100);
            $promo_harga = $product->product_price_selling - $discount;

            if ($sales_qty) {
                $promo_limit_qty = $sales_qty->quantity + $request->quantity;
                if ($promo_limit_qty >= $promo->promo->minimum_order_qty) {
                    $discount = $product->product_price_selling * ($promo->promo->discount_percent / 100);
                    $promo_harga = $product->product_price_selling - $discount;

                    $sales_qty->sub_total = 0;
                    $sales_qty->promo_harga = $promo_harga;
                    $sales_qty->promo_total = $promo_limit_qty * $promo_harga;
                } else {
                    $sales_qty->sub_total = $sales_qty->sub_total + $request->sub_total;
                }

                $sales_qty->quantity = $promo_limit_qty;
                $sales_qty->promo_id = $promo->id;
                $sales_qty->save();
            } else {
                $sales = new Sales;
                $sales->user_id = Auth::user()->id;
                $sales->shop_id = Auth::user()->employee->shop_id;
                $sales->product_id = $request->product_id;
                $sales->quantity = $request->quantity;

                if ($request->quantity >= $promo->promo->minimum_order_qty) {
                    $sales->sub_total = 0;
                    $sales->promo_harga = $promo_harga;
                    $sales->promo_total = $request->quantity * $promo_harga;
                } else {
                    $sales->sub_total = $request->sub_total;
                }

                $sales->promo_id = $promo->id;
                $sales->save();
            }

            $stock = ProductShop::where('product_id', $request->product_id)->where('shop_id', Auth::user()->employee->shop_id)->first();
            $stock->stock = $stock->stock - $request->quantity;
            $stock->save();

            return response()->json([
                'status' => "true"
            ]);
        } else {
            return response()->json([
                'status' => "false" // stok barang tidak cukup
            ]);
        }
    }

    public function delete($id)
    {
        $sales = Sales::find($id);

        // update stock
        $stock = ProductShop::where('product_id', $sales->product_id)->where('shop_id', Auth::user()->employee->shop_id)->first();
        $stock->stock = $stock->stock + $sales->quantity;
        $stock->save();

        $sales->delete();


        return redirect()->route('cashier.index');
    }

    public function print(Request $request)
    {
        $invoice_code = Str::random(10);
        $poin = $request->total_amount / 1000;
        $round_poin = floor($poin);

        $invoice = new Invoice;

        if ($request->customer_id) {
            $invoice->customer_id = $request->customer_id;
            $invoice->discount = $request->discount;
            $invoice->poin = $round_poin;

            $customer = Customer::find($request->customer_id);
            $customer->poin = $customer->poin + $round_poin;
            $customer->save();
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
        $invoice->pay_method = $request->pay_method;
        $invoice->bayar = $request->bayar;
        $invoice->kembalian = $request->kembalian;

        if ($request->pay_method == "credit") {
            $invoice->debt = $request->total_amount;
        }

        $invoice->save();

        $sales = Sales::where('user_id', Auth::user()->id)->where('invoice_id', null)->update(['invoice_id' => $invoice->id]);

        $sales_query = Sales::where('invoice_id', $invoice->id)->get();

        if ($request->credit) {
            for ($i=1; $i <= $request->credit; $i++) {
                $credit_payments = new CreditPayment;
                $credit_payments->credit = $i;
                $credit_payments->customer_id = $request->customer_id;
                $credit_payments->invoice_id = $invoice->id;
                $credit_payments->save();
            }
        }

        return response()->json([
            'invoice_id' => $invoice->id,
            'invoice_code' => $invoice_code,
            'invoice_date' => date('d-m-Y', strtotime($invoice->date_recorded)),
            'invoice_time' => date('H:i:s', strtotime($invoice->date_recorded)),
            'sales' => $sales_query
        ]);
    }

    public function printResult($id)
    {
        $shop = Shop::find(Auth::user()->employee->shop_id);
        $invoice = Invoice::find($id);
        $product_outs = Sales::where('invoice_id', $id)->get();
        $customer = Customer::find($invoice->customer_id);

        return view('pages.cashier.print', [
            'shop' => $shop,
            'invoice' => $invoice,
            'product_outs' => $product_outs,
            'customer' => $customer
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
