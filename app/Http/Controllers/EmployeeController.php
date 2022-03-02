<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index()
    {
        $employee = Employee::orderBy('id', 'desc')->get();

        return view('pages.employee.index', ['employees' => $employee]);
    }

    public function create()
    {
        $shop = Shop::get();
        $position = Position::get();

        return response()->json([
            'shops' => $shop,
            'positions' => $position
        ]);
    }

    public function store(Request $request)
    {
        $employee = new Employee;
        $employee->shop_id = $request->shop_id;
        $employee->full_name = $request->full_name;
        $employee->nickname = $request->nickname;
        $employee->email = $request->email;
        $employee->contact = $request->contact;
        $employee->address = $request->address;
        $employee->position_id = $request->position_id;
        $employee->save();

        return response()->json([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        $position = Position::find($employee->position_id);
        $shop = Shop::find($employee->shop_id);

        return response()->json([
            'id' => $employee->id,
            'full_name' => $employee->full_name,
            'nickname' => $employee->nickname,
            'email' => $employee->email,
            'contact' => $employee->contact,
            'address' => $employee->address,
            'shop' => $shop ? $shop->name : 'kosong',
            'position' => $position ? $position->name : 'kosong'
        ]);
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        $position = Position::get();
        $shop = Shop::get();

        return response()->json([
            'id' => $employee->id,
            'full_name' => $employee->full_name,
            'nickname' => $employee->nickname,
            'email' => $employee->email,
            'contact' => $employee->contact,
            'address' => $employee->address,
            'shop_id' => $employee->shop_id,
            'shops' => $shop,
            'position_id' => $employee->position_id,
            'positions' => $position
        ]);
    }

    public function update(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->shop_id = $request->shop_id;
        $employee->full_name = $request->full_name;
        $employee->nickname = $request->nickname;
        $employee->email = $request->email;
        $employee->contact = $request->contact;
        $employee->address = $request->address;
        $employee->position_id = $request->position_id;
        $employee->save();

        $position = Position::find($employee->position_id);
        $shop = Shop::find($employee->shop_id);

        return response()->json([
            'status' => 'Data berhasil diperbaharui',
            'id' => $request->id,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'shop' => $shop->name,
            'position' => $position->name
        ]);
    }

    public function deleteBtn($id)
    {
        $employee = Employee::find($id);

        return response()->json([
            'id' => $employee->id,
            'full_name' => $employee->full_name
        ]);
    }

    public function delete(Request $request)
    {
        $employee = Employee::find($request->id);
        $employee->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
