<?php

namespace App\Http\Controllers;

use App\Models\WmNasabah;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function index()
    {
        $nasabah = WmNasabah::get();

        return view('pages.wm_angsuran.index', ['nasabahs' => $nasabah]);
    }

    public function store(Request $request)
    {
        $nasabah = new WmNasabah;
        $nasabah->nama = $request->nama;
        $nasabah->nomor_kontrak = $request->nomor_kontrak;
        $nasabah->save();

        return response()->json([
            'status' => 'Data berhasil di simpan'
        ]);
    }

    public function edit($id)
    {
        $nasabah = WmNasabah::find($id);

        return response()->json([
            'nasabah' => $nasabah
        ]);
    }

    public function update(Request $request)
    {
        $nasabah = WmNasabah::find($request->id);
        $nasabah->nama = $request->nama;
        $nasabah->nomor_kontrak = $request->nomor_kontrak;
        $nasabah->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui'
        ]);
    }

    public function deleteBtn($id)
    {
        $nasabah = WmNasabah::find($id);

        return response()->json([
            'nasabah' => $nasabah
        ]);
    }

    public function delete(Request $request)
    {
        $nasabah = WmNasabah::find($request->id);
        $nasabah->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
