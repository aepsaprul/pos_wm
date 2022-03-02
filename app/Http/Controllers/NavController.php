<?php

namespace App\Http\Controllers;

use App\Models\NavMain;
use App\Models\NavSub;
use App\Models\NavSubUser;
use App\Models\RolesNavMain;
use App\Models\RolesNavSub;
use Illuminate\Http\Request;

class NavController extends Controller
{
    public function index()
    {
        $nav_main = NavMain::get();
        $nav_sub = NavSub::orderBy('nav_main_id', 'asc')->get();

        return view('pages.navigasi.index', ['nav_mains' => $nav_main, 'nav_subs' => $nav_sub]);
    }

    public function mainStore(Request $request)
    {
        $nav_main = new NavMain;
        $nav_main->title = $request->title;
        $nav_main->link = $request->link;
        $nav_main->save();

        return response()->json([
            'status' => 'Data menu utama berhasil ditambah'
        ]);
    }

    public function subCreate()
    {
        $nav_main = NavMain::get();

        return response()->json([
            'nav_mains' => $nav_main
        ]);
    }

    public function subStore(Request $request)
    {
        $nav_sub = new NavSub;
        $nav_sub->title = $request->title;
        $nav_sub->link = $request->link;
        $nav_sub->nav_main_id = $request->nav_main_id;
        $nav_sub->save();

        return response()->json([
            'status' => 'Data menu sub berhasil ditambah'
        ]);
    }

    public function mainEdit($id)
    {
        $nav_main = NavMain::find($id);

        return response()->json([
            'id' => $nav_main->id,
            'title' => $nav_main->title,
            'link' => $nav_main->link
        ]);
    }

    public function subEdit($id)
    {
        $nav_sub = NavSub::find($id);
        $nav_main = NavMain::get();

        return response()->json([
            'id' => $nav_sub->id,
            'title' => $nav_sub->title,
            'link' => $nav_sub->link,
            'nav_main_id' => $nav_sub->nav_main_id,
            'nav_mains' => $nav_main
        ]);
    }

    public function mainUpdate(Request $request)
    {
        $nav_main = NavMain::find($request->id);
        $nav_main->title = $request->title;
        $nav_main->link = $request->link;
        $nav_main->save();

        return response()->json([
            'id' => $request->id,
            'status' => 'Data menu utama berhasil diperbaharui',
            'title' => $request->title,
            'link' => $request->link
        ]);
    }

    public function subUpdate(Request $request)
    {
        $nav_sub = NavSub::find($request->id);
        $nav_sub->title = $request->title;
        $nav_sub->link = $request->link;
        $nav_sub->nav_main_id = $request->nav_main_id;
        $nav_sub->save();

        $nav_main = NavMain::find($request->nav_main_id);


        return response()->json([
            'id' => $request->id,
            'status' => 'Data menu sub berhasil diperbaharui',
            'title' => $request->title,
            'link' => $request->link,
            'nav_main_title' => $nav_main->title
        ]);
    }

    public function mainDeleteBtn($id)
    {
        $nav_main = NavMain::find($id);

        return response()->json([
            'id' => $nav_main->id,
            'title' => $nav_main->title
        ]);
    }

    public function mainDelete(Request $request)
    {
        $nav_main = NavMain::find($request->id);

        $nav_sub = NavSub::where('nav_main_id', $request->id)->first();

        if ($nav_sub) {
            $status = "false";
        } else {
            $nav_main->delete();

            $roles_nav_main = RolesNavMain::where('nav_main_id', $nav_main->id);
            $roles_nav_main->delete();

            $status = "true";
        }

        return response()->json([
            'status' => $status,
            'title' => $nav_main->title
        ]);
    }

    public function subDeleteBtn($id)
    {
        $nav_sub = NavSub::find($id);

        return response()->json([
            'id' => $nav_sub->id,
            'title' => $nav_sub->title
        ]);
    }

    public function subDelete(Request $request)
    {
        $nav_sub = NavSub::find($request->id);
        $nav_sub->delete();

        $roles_nav_sub = RolesNavSub::where('nav_sub_id', $nav_sub->id);
        $roles_nav_sub->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
