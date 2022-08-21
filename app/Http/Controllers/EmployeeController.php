<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NavigasiAccess;
use App\Models\NavigasiButton;
use App\Models\NavigasiMain;
use App\Models\NavigasiSub;
use App\Models\Position;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function akses($id) {
        $employee = Employee::find($id);

        $nav_access = NavigasiAccess::where('karyawan_id', $id)->get();

        $nav_button = NavigasiButton::get();
        $nav_sub = NavigasiSub::get();
        $nav_main = NavigasiMain::with(['navigasiSub', 'navigasiSub.navigasiButton', 'navigasiButton'])
            ->get();

        $button = NavigasiButton::with('navigasiSub')
            ->select(DB::raw('count(sub_id) as total'), DB::raw('count(main_id) as mainid'), 'sub_id')
            ->groupBy('sub_id')
            ->get();

        $total_main = NavigasiButton::with('navigasiSub')
            ->select(DB::raw('count(main_id) as total_main'), 'main_id')
            ->groupBy('main_id')
            ->get();

        return view('pages.employee.akses', [
            'employee' => $employee,
            'nav_access' => $nav_access,
            'nav_buttons' => $nav_button,
            'buttons' => $button,
            'total_main' => $total_main,
            'nav_subs' => $nav_sub,
            'nav_mains' => $nav_main
        ]);
    }

    public function aksesStore(Request $request)
    {
        $nav_access = NavigasiAccess::where('karyawan_id', $request->karyawan_id);

        if ($nav_access) {
            $nav_access->delete();

            foreach ($request->button_check as $key => $value) {
                $nav_access = new NavigasiAccess;
                $nav_access->karyawan_id = $request->karyawan_id;
                $nav_access->button_id = $value;
                $nav_access->save();
            }
        } else {
            foreach ($request->button_check as $key => $value) {
                $nav_access = new NavigasiAccess;
                $nav_access->karyawan_id = $request->karyawan_id;
                $nav_access->button_id = $value;
                $nav_access->save();
            }
        }

        return redirect()->route('employee.index')->with('sukses', 'Data berhasil disimpan');
    }
}
