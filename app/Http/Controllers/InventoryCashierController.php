<?php

namespace App\Http\Controllers;

use App\Models\InventoryInvoice;
use App\Models\InventoryProductIn;
use App\Models\InventoryProductOut;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryCashierController extends Controller
{
    public function index()
    {
        $pruduct = Product::get();
        $shop = Shop::where('id', '!=', 1)->get();

        $product_out = InventoryProductOut::where('invoice_id', null)->get();
        $total_price = $product_out->sum('sub_total');

        return view('pages.inventory_cashier.index', [
            'products' => $pruduct,
            'shops' => $shop,
            'total_price' => $total_price,
            'product_outs' => $product_out
        ]);
    }

    public function getProduct(Request $request)
    {
        $product = Product::where('product_code', $request->product_code)
            ->orWhere('id', $request->product_manual)
            ->first();

        return response()->json([
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'stock' => $product->stock,
            'product_price' => $product->product_price_selling
        ]);
    }

    public function productOutSave(Request $request)
    {
        $product_out_qty = InventoryProductOut::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->where('invoice_id', null)
            ->first();

        if ($product_out_qty) {
            $product_out_qty->quantity = $product_out_qty->quantity + $request->quantity;
            $product_out_qty->sub_total = $product_out_qty->sub_total + $request->sub_total;
            $product_out_qty->save();
        } else {
            $product_out = new InventoryProductOut();
            $product_out->user_id = Auth::user()->id;
            $product_out->shop_id = $request->shop_id;
            $product_out->product_id = $request->product_id;
            $product_out->quantity = $request->quantity;
            $product_out->sub_total = $request->sub_total;
            $product_out->save();
        }

        // update stock
        $product_in_stock = InventoryProductIn::where('product_id', $request->product_id)
            ->whereNotNull('stock')
            ->where('stock', '>', 0)
            ->select(DB::raw('sum(stock) as total_stock'))
            ->first();

        $stock_all = $product_in_stock->total_stock;
        $qty = $request->quantity;

        $product_in = InventoryProductIn::where('product_id', $request->product_id)
            ->whereNotNull('stock')
            ->where('stock', '>', 0)
            ->get();

        if ($qty <= $stock_all) {
            foreach ($product_in as $key => $item) {
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

                    $product_in_update = InventoryProductIn::where('product_id', $request->product_id)->where('id', $id)->first();
                    $product_in_update->stock = $stock_update;
                    $product_in_update->save();
                }
            }
        } else {
            echo "stok barang tidak cukup";
        }


        $stock = Product::where('id', $request->product_id)->first();
        $stock->stock = $stock->stock - $request->quantity;
        $stock->save();

        return response()->json([
            'status' => "data berhasil ditambahkan"
        ]);
    }

    public function delete($id)
    {
        $inventory_product_out = InventoryProductOut::find($id);

        // update stock
        $stock = Product::where('id', $inventory_product_out->product_id)->first();
        $stock->stock = $stock->stock + $inventory_product_out->quantity;
        $stock->save();

        $inventory_product_out->delete();


        return redirect()->route('inventory_cashier.index');
    }

    public function print(Request $request)
    {
        $invoice_code = Str::random(10);

        $invoice = new InventoryInvoice;
        $invoice->total_amount = $request->total_amount;
        $invoice->date_recorded = date('Y-m-d H:i:s');
        $invoice->user_id = Auth::user()->id;
        $invoice->shop_id = $request->shop_id;
        $invoice->code = $invoice_code;
        $invoice->save();

        $inventory_product_out = InventoryProductOut::where('user_id', Auth::user()->id)->where('invoice_id', null)->update(['invoice_id' => $invoice->id]);

        $inventory_product_out_query = InventoryProductOut::where('invoice_id', $invoice->id)->get();

        return response()->json([
            'invoice_code' => $invoice_code,
            'invoice_date' => date('d-m-Y', strtotime($invoice->date_recorded)),
            'invoice_time' => date('H:i:s', strtotime($invoice->date_recorded)),
            'inventory_product_outs' => $inventory_product_out_query
        ]);
    }
}
