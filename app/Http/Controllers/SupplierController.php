<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::get();

        return view('pages.supplier.index', ['suppliers' => $supplier]);
    }

    public function store(Request $request)
    {
        $supplier = new Supplier;
        $supplier->supplier_code = $request->supplier_code;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_email = $request->email;
        $supplier->supplier_contact = $request->contact;
        $supplier->supplier_address = $request->address;
        $supplier->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);

        return response()->json([
            'supplier_id' => $supplier->id,
            'supplier_code' => $supplier->supplier_code,
            'supplier_name' => $supplier->supplier_name,
            'email' => $supplier->supplier_email,
            'contact' => $supplier->supplier_contact,
            'address' => $supplier->supplier_address
        ]);
    }

    public function update(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->supplier_code = $request->supplier_code;
        $supplier->supplier_name = $request->supplier_name;
        $supplier->supplier_email = $request->email;
        $supplier->supplier_contact = $request->contact;
        $supplier->supplier_address = $request->address;
        $supplier->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $supplier = Supplier::find($id);

        return response()->json([
            'id' => $supplier->id,
            'supplier_name' => $supplier->supplier_name
        ]);
    }

    public function delete(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
