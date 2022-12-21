<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NavAccess;
use App\Models\NavigasiAccess;
use App\Models\NavigasiButton;
use App\Models\NavigasiMain;
use App\Models\NavigasiSub;
use App\Models\NavMain;
use App\Models\NavMainUser;
use App\Models\NavSub;
use App\Models\NavSubUser;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with(['employee', 'employee.position'])->where('employee_id', '!=', null)->orderBy('id', 'desc')->get();

        return view('pages.user.index', ['users' => $user]);
    }

    public function create()
    {
        $employee = Employee::doesntHave('navAccess')->get();

        return response()->json([
            'employees' => $employee
        ]);
    }

    public function store(Request $request)
    {
        $employee = Employee::find($request->employee_id);

        $user = new User;
        $user->name = $employee->full_name;
        $user->email = $employee->email;
        $user->password = Hash::make($request->password);
        $user->employee_id = $request->employee_id;
        $user->save();

        $nav_sub = NavSub::get();

        foreach ($nav_sub as $key => $item) {
            $nav_access = new NavAccess;
            $nav_access->user_id = $request->employee_id;
            $nav_access->main_id = $item->nav_main_id;
            $nav_access->sub_id = $item->id;
            $nav_access->tampil = "n";
            $nav_access->tambah = "n";
            $nav_access->ubah = "n";
            $nav_access->hapus = "n";
            $nav_access->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function access($id)
    {
        $user = User::find($id);

        $employee = Employee::where('id', $user->employee_id)->first();
        $menu = NavAccess::where('user_id', $user->employee_id)->get();
        $sub = NavAccess::with('navMain')
            ->where('user_id', $user->employee_id)
            ->select(DB::raw('count(main_id) as total'),'main_id')
            ->groupBy('main_id')
            ->get();

        $employee_id = $employee->id;
        $sync = DB::table('nav_subs')
            ->select('nav_subs.id AS nav_sub_id', 'nav_subs.title AS title', 'nav_subs.nav_main_id AS nav_main')
            ->leftJoin('nav_accesses', function($join) use ($employee_id) {
                $join->on('nav_subs.id', '=', 'nav_accesses.sub_id')
                    ->where('nav_accesses.user_id', '=', $employee_id);
            })
            ->whereNull('user_id')
            ->get();

            // dd($sync);

            // SELECT * FROM
            // (select * FROM `nav_accesses` WHERE user_id = 4) AS nav_user
            // LEFT JOIN nav_subs ON (nav_subs.id = nav_user.sub_id);

            // SELECT * FROM nav_subs LEFT JOIN
            //     (SELECT * FROM nav_accesses WHERE user_id = 3)
            //     AS navaccess ON navaccess.sub_id = nav_subs.id WHERE user_id IS null;

        return view('pages.user.access', [
            'employee' => $employee,
            'menus' => $menu,
            'subs' => $sub,
            'syncs' => $sync
        ]);
    }

    public function accessSave(Request $request, $id)
    {
        $nav_access = NavAccess::find($id);

        if ($request->show) {
            $nav_access->tampil = $request->show;
        }
        if ($request->create) {
            $nav_access->tambah = $request->create;
        }
        if ($request->edit) {
            $nav_access->ubah = $request->edit;
        }
        if ($request->delete) {
            $nav_access->hapus = $request->delete;
        }

        $nav_access->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function deleteBtn($id)
    {
        $user = User::find($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name
        ]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        $employee = Employee::where('id', $user->employee_id)->first();
        $nav_access = NavAccess::where('user_id', $employee->id);
        $nav_access->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }

    public function sync(Request $request)
    {
        $employee = Employee::where('id', $request->id)->first();

        $employee_id = $employee->id;
        $sync = DB::table('nav_subs')
            ->select('nav_subs.id AS nav_sub_id', 'nav_subs.title AS title', 'nav_subs.nav_main_id AS nav_main')
            ->leftJoin('nav_accesses', function($join) use ($employee_id) {
                $join->on('nav_subs.id', '=', 'nav_accesses.sub_id')
                    ->where('nav_accesses.user_id', '=', $employee_id);
            })
            ->whereNull('user_id')
            ->get();

        foreach ($sync as $key => $item) {
            $nav_access = new NavAccess;
            $nav_access->user_id = $employee->id;
            $nav_access->main_id = $item->nav_main;
            $nav_access->sub_id = $item->nav_sub_id;
            $nav_access->tampil = "n";
            $nav_access->tambah = "n";
            $nav_access->ubah = "n";
            $nav_access->hapus = "n";
            $nav_access->save();
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function akses($id) {
        $user = User::find($id);

        $employee = Employee::find($user->employee_id);

        $nav_access = NavigasiAccess::where('karyawan_id', $employee->id)->get();

        $nav_button = NavigasiButton::get();
        $nav_sub = NavigasiSub::get();
        $nav_main = NavigasiMain::with(['navigasiSub', 'navigasiSub.navigasiButton', 'navigasiButton'])
            ->orderBy('hirarki', 'asc')
            ->get();

        $button = NavigasiButton::with('navigasiSub')
            ->select(DB::raw('count(sub_id) as total'), DB::raw('count(main_id) as mainid'), 'sub_id')
            ->groupBy('sub_id')
            ->get();

        $total_main = NavigasiButton::with('navigasiSub')
            ->select(DB::raw('count(main_id) as total_main'), 'main_id')
            ->groupBy('main_id')
            ->get();

        return view('pages.user.akses', [
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

        return redirect()->route('user.index')->with('sukses', 'Data berhasil disimpan');
    }
}
