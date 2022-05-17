<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        if (Auth::user()->employee) {
            $shop_id = Auth::user()->employee->shop->id;
            $customer = Customer::where('shop_id', $shop_id)->get();

            return view('pages.customer.index', ['customers' => $customer]);
        } else {
            return view('page_403');
        }
    }

    public function store(Request $request)
    {
        $customer = new Customer;

        if (Auth::user()->employee) {
            $customer->shop_id = Auth::user()->employee->shop->id;
        }

        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;
        $customer->contact = $request->contact;
        $customer->address = $request->address;
        $customer->debit_card = $request->debit_card;
        $customer->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'customer_id' => $customer->id,
            'customer_name' => $customer->customer_name,
            'email' => $customer->email,
            'contact' => $customer->contact,
            'address' => $customer->address,
            'debit_card' => $customer->debit_card
        ]);
    }

    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;
        $customer->contact = $request->contact;
        $customer->address = $request->address;
        $customer->debit_card = $request->debit_card;
        $customer->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'id' => $customer->id,
            'customer_name' => $customer->customer_name
        ]);
    }

    public function delete(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
