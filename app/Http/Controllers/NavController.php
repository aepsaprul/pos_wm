<?php

namespace App\Http\Controllers;

use App\Models\NavigasiButton;
use App\Models\NavigasiMain;
use App\Models\NavigasiSub;
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
        $nav_main = NavigasiMain::get();
        $nav_sub = NavigasiSub::orderBy('main_id', 'asc')->get();
        $nav_tombol = NavigasiButton::orderBy('main_id', 'asc')->get();

        return view('pages.navigasi.index', [
            'nav_mains' => $nav_main,
            'nav_subs' => $nav_sub,
            'nav_tombols' => $nav_tombol
        ]);
    }

    public function mainStore(Request $request)
    {
        $nav_main = new NavigasiMain;
        $nav_main->title = $request->title;
        $nav_main->link = $request->link;
        $nav_main->icon = $request->icon;
        $nav_main->aktif = $request->aktif;
        $nav_main->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function subCreate()
    {
        $nav_main = NavigasiMain::get();

        return response()->json([
            'nav_mains' => $nav_main
        ]);
    }

    public function subStore(Request $request)
    {
        $nav_sub = new NavigasiSub;
        $nav_sub->title = $request->title;
        $nav_sub->link = $request->link;
        $nav_sub->main_id = $request->main_id;
        $nav_sub->aktif = $request->aktif;
        $nav_sub->save();

        return response()->json([
            'status' => 'Data menu sub berhasil ditambah'
        ]);
    }

    public function tombolCreate()
    {
        $nav_main = NavigasiMain::get();
        $nav_sub = NavigasiSub::get();

        return response()->json([
            'nav_mains' => $nav_main,
            'nav_subs' => $nav_sub
        ]);
    }

    public function tombolStore(Request $request)
    {
        $nav_tombol = new NavigasiButton;
        $nav_tombol->title = $request->title;
        $nav_tombol->link = $request->link;
        $nav_tombol->sub_id = $request->sub_id;
        $nav_tombol->main_id = $request->main_id;
        $nav_tombol->save();

        return response()->json([
            'status' => 'Data menu tombol berhasil ditambah'
        ]);
    }

    public function mainEdit($id)
    {
        $nav_main = NavigasiMain::find($id);

        return response()->json([
            'id' => $nav_main->id,
            'title' => $nav_main->title,
            'link' => $nav_main->link,
            'icon' => $nav_main->icon,
            'aktif' => $nav_main->aktif
        ]);
    }

    public function subEdit($id)
    {
        $nav_sub = NavigasiSub::find($id);
        $nav_main = NavigasiMain::get();

        return response()->json([
            'id' => $nav_sub->id,
            'title' => $nav_sub->title,
            'link' => $nav_sub->link,
            'main_id' => $nav_sub->main_id,
            'aktif' => $nav_sub->aktif,
            'nav_mains' => $nav_main
        ]);
    }

    public function tombolEdit($id)
    {
        $nav_tombol = NavigasiButton::find($id);
        $nav_main = NavigasiMain::get();
        $nav_sub = NavigasiSub::get();

        return response()->json([
            'id' => $nav_tombol->id,
            'title' => $nav_tombol->title,
            'link' => $nav_tombol->link,
            'sub_id' => $nav_tombol->sub_id,
            'main_id' => $nav_tombol->main_id,
            'nav_mains' => $nav_main,
            'nav_subs' => $nav_sub
        ]);
    }

    public function mainUpdate(Request $request)
    {
        $nav_main = NavigasiMain::find($request->id);
        $nav_main->title = $request->title;
        $nav_main->link = $request->link;
        $nav_main->icon = $request->icon;
        $nav_main->aktif = $request->aktif;
        $nav_main->save();

        return response()->json([
            'id' => $request->id,
            'status' => 'true',
            'title' => $request->title,
            'link' => $request->link,
            'icon' => $request->icon,
            'aktif' => $request->aktif
        ]);
    }

    public function subUpdate(Request $request)
    {
        $nav_sub = NavigasiSub::find($request->id);
        $nav_sub->title = $request->title;
        $nav_sub->link = $request->link;
        $nav_sub->main_id = $request->main_id;
        $nav_sub->aktif = $request->aktif;
        $nav_sub->save();

        $nav_main = NavigasiMain::find($request->main_id);

        return response()->json([
            'id' => $request->id,
            'status' => 'Data menu sub berhasil diperbaharui',
            'title' => $request->title,
            'link' => $request->link,
            'main_title' => $nav_main->title,
            'aktif' => $request->aktif
        ]);
    }

    public function tombolUpdate(Request $request)
    {
        $nav_tombol = NavigasiButton::find($request->id);
        $nav_tombol->title = $request->title;
        $nav_tombol->link = $request->link;
        $nav_tombol->sub_id = $request->sub_id;
        $nav_tombol->main_id = $request->main_id;
        $nav_tombol->save();

        $nav_main = NavigasiMain::find($request->main_id);
        $nav_sub = NavigasiSub::find($request->sub_id);

        return response()->json([
            'id' => $request->id,
            'status' => 'Data menu tombol berhasil diperbaharui',
            'title' => $request->title,
            'link' => $request->link,
            'main_title' => $nav_main->title,
            'sub_title' => $nav_sub->title
        ]);
    }

    public function mainDeleteBtn($id)
    {
        $nav_main = NavigasiMain::find($id);

        return response()->json([
            'id' => $nav_main->id,
            'title' => $nav_main->title
        ]);
    }

    public function mainDelete(Request $request)
    {
        $nav_main = NavigasiMain::find($request->id);

        $nav_sub = NavigasiSub::where('main_id', $request->id)->first();

        if ($nav_sub) {
            $status = "false";
        } else {
            $nav_main->delete();

            $status = "true";
        }

        return response()->json([
            'status' => $status,
            'title' => $nav_main->title
        ]);
    }

    public function subDeleteBtn($id)
    {
        $nav_sub = NavigasiSub::find($id);

        return response()->json([
            'id' => $nav_sub->id,
            'title' => $nav_sub->title
        ]);
    }

    public function subDelete(Request $request)
    {
        $nav_sub = NavigasiSub::find($request->id);
        $nav_sub->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }

    public function tombolDeleteBtn($id)
    {
        $nav_tombol = NavigasiButton::find($id);

        return response()->json([
            'id' => $nav_tombol->id,
            'title' => $nav_tombol->title
        ]);
    }

    public function tombolDelete(Request $request)
    {
        $nav_tombol = NavigasiButton::find($request->id);
        $nav_tombol->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
