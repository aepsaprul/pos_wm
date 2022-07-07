<?php

namespace App\Http\Controllers;

use App\Models\WmAngsuran;
use App\Models\WmAngsuranDetail;
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
        $angsuran->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function tambahAngsuranEdit($id)
    {
        $angsuran = WmAngsuran::find($id);

        return response()->json([
            'angsuran' => $angsuran
        ]);
    }

    public function tambahAngsuranUpdate(Request $request)
    {
        $angsuran = WmAngsuran::find($request->id);
        $angsuran->nama = $request->nama_angsuran;
        $angsuran->jumlah = $request->jumlah;
        $angsuran->total = $request->total;
        $angsuran->save();

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function tambahAngsuranDelete(Request $request)
    {
        $angsuran = WmAngsuran::find($request->id);
        $angsuran->delete();

        return response()->json([
            'status' => 'true'
        ]);
    }

    // bayar angsuran
    public function bayarAngsuran($id)
    {
        $nasabah = WmNasabah::find($id);
        $angsuran_detail = WmAngsuranDetail::whereHas('angsuran', function ($query) use ($nasabah) {
            $query->where('nasabah_id', $nasabah->id)->where('status', 'hutang');
        })
        ->orderBy('angsuran_id', 'asc')
        ->orderBy('angsuran_ke', 'asc')
        ->get();

        return view('pages.wm_angsuran.bayar_angsuran', ['nasabah' => $nasabah, 'angsuran_details' => $angsuran_detail]);
    }

    public function bayarAngsuranCreate($id)
    {
        $angsuran = WmAngsuran::where('nasabah_id', $id)->where('status', 'hutang')->get();

        return response()->json([
            'angsurans' => $angsuran
        ]);
    }

    public function bayarAngsuranCreateAngsuranKe($id)
    {
        $angsuran = WmAngsuran::find($id);

        if ($angsuran) {
            $angsuran_detail = count(WmAngsuranDetail::where('angsuran_id', $id)->get());
            $angsuran_ke = $angsuran->jumlah - $angsuran_detail;
            $angsuran_akhir = $angsuran->jumlah;
        } else {
            $angsuran_detail = 0;
            $angsuran_ke = 0;
            $angsuran_akhir = 0;
        }

        return response()->json([
            'angsuran_detail' => $angsuran_detail,
            'angsuran_ke' => $angsuran_ke,
            'angsuran_akhir' => $angsuran_akhir
        ]);
    }

    public function bayarAngsuranStore(Request $request)
    {
        $angsuran_detail = new WmAngsuranDetail;
        $angsuran_detail->angsuran_id = $request->nama_angsuran;
        $angsuran_detail->angsuran_ke = $request->angsuran_ke;
        $angsuran_detail->nominal = $request->nominal;
        $angsuran_detail->save();

        $angsuran = WmAngsuran::find($request->nama_angsuran);

        if ($angsuran->jumlah == $request->angsuran_ke) {
            $angsuran->status = "lunas";
            $angsuran->save();
        } else {
            $angsuran->status = "hutang";
            $angsuran->save();
        }

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function bayarAngsuranDelete(Request $request)
    {
        $angsuran_detail = WmAngsuranDetail::find($request->id);
        $angsuran_detail->delete();

        return response()->json([
            'status' => 'true'
        ]);
    }
}
