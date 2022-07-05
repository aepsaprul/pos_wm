<?php

namespace App\Http\Controllers;

use App\Models\WmAngsuran;
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

    // tambah angsuran
    public function tambahAngsuran($id)
    {
        $nasabah = WmNasabah::find($id);
        $angsuran = WmAngsuran::where('nasabah_id', $id)->get();

        return view('pages.wm_angsuran.tambah_angsuran', ['angsurans' => $angsuran, 'nasabah' => $nasabah]);
    }

    public function tambahAngsuranStore(Request $request)
    {
        $angsuran = new WmAngsuran;
        $angsuran->nasabah_id = $request->nasabah_id;
        $angsuran->nama = $request->nama_angsuran;
        $angsuran->jumlah = $request->jumlah;
        $angsuran->total = $request->total;
        $angsuran->status = $request->status;
        $angsuran->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function tambahAngsuranEdit($id)
    {

    }

    public function tambahAngsuranUpdate(Request $request)
    {

    }

    public function tambahAngsuranDelete($id)
    {

    }

    // bayar angsuran
    public function bayarAngsuran($id)
    {
        $nasabah = WmNasabah::find($id);

        return view('pages.wm_angsuran.bayar_angsuran', ['nasabah' => $nasabah]);
    }

    public function bayarAngsuranDelete($id)
    {

    }
}
