<?php

namespace App\Http\Controllers;

use App\Models\NavMain;
use App\Models\Roles;
use App\Models\RolesNavMain;
use App\Models\RolesNavSub;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::get();

        return view('pages.roles.index', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $roles = new Roles;
        $roles->name = $request->name;
        $roles->save();

        return response()->json([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function edit($id)
    {
        $roles = Roles::find($id);

        return response()->json([
            'id' => $roles->id,
            'name' => $roles->name
        ]);
    }

    public function update(Request $request)
    {
        $roles = Roles::find($request->id);
        $roles->name = $request->name;
        $roles->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui',
            'id' => $request->id,
            'name' => $request->name
        ]);
    }

    public function deleteBtn($id)
    {
        $roles = Roles::find($id);

        return response()->json([
            'id' => $roles->id,
            'name' =>$roles->name
        ]);
    }

    public function delete(Request $request)
    {
        $roles = Roles::find($request->id);
        $roles->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }

    public function access($id)
    {
        $roles = Roles::find($id);

        // menu utama
        $rolesNavMain = RolesNavMain::where('roles_id', $id)->get();
        $nav_main = NavMain::with('navSub')->get();

        // menu sub
        $rolesNavSub = RolesNavSub::where('roles_id', $id)->get();

        return response()->json([
            'id' => $id,
            'roles' => $roles,
            'nav_mains' => $nav_main,
            'roles_nav_mains' => $rolesNavMain,
            'roles_nav_subs' => $rolesNavSub
        ]);
    }

    public function accessSave(Request $request)
    {
        // menu utama
        $rolesNavMain = RolesNavMain::where('roles_id', $request->id)->get();

        if (count($rolesNavMain) == 0) {
            foreach ($request->nav_main as $key => $item) {
                $rolesNavMainCreate = new RolesNavMain;
                $rolesNavMainCreate->roles_id = $request->id;
                $rolesNavMainCreate->nav_main_id = $item;
                $rolesNavMainCreate->save();
            }
        } else {
            $rolesNavMainHapus = RolesNavMain::where('roles_id', $request->id);
            $rolesNavMainHapus->delete();

            foreach ($request->nav_main as $key => $item) {
                $rolesNavMainCreate = new RolesNavMain;
                $rolesNavMainCreate->roles_id = $request->id;
                $rolesNavMainCreate->nav_main_id = $item;
                $rolesNavMainCreate->save();
            }
        }

        // menu sub
        if ($request->nav_sub) {
            # code...
            $rolesNavSub = RolesNavSub::where('roles_id', $request->id)->get();

            if (count($rolesNavSub) == 0) {

                foreach ($request->nav_sub as $key => $item) {
                    $rolesNavSubCreate = new RolesNavSub;
                    $rolesNavSubCreate->roles_id = $request->id;
                    $rolesNavSubCreate->nav_sub_id = $item;
                    $rolesNavSubCreate->save();
                }
            } else {
                $rolesNavSubHapus = RolesNavSub::where('roles_id', $request->id);
                $rolesNavSubHapus->delete();

                foreach ($request->nav_sub as $key => $item) {
                    $rolesNavSubCreate = new RolesNavSub;
                    $rolesNavSubCreate->roles_id = $request->id;
                    $rolesNavSubCreate->nav_sub_id = $item;
                    $rolesNavSubCreate->save();
                }
            }
        } else {
            $rolesNavSubHapus = RolesNavSub::where('roles_id', $request->id);
            $rolesNavSubHapus->delete();
        }

        return response()->json([
            'status' => 'Akses berhasil'
        ]);
    }
}
