<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $position = Position::get();

        return view('pages.position.index', ['positions' => $position]);
    }

    public function store(Request $request)
    {
        $position = new Position;
        $position->name = $request->name;
        $position->save();

        return response()->json([
            'status' => 'Data berhasil disimpan'
        ]);
    }

    public function edit($id)
    {
        $position = Position::find($id);

        return response()->json([
            'id' => $position->id,
            'name' => $position->name
        ]);
    }

    public function update(Request $request)
    {
        $position = Position::find($request->id);
        $position->name = $request->name;
        $position->save();

        return response()->json([
            'status' => 'Data berhasil diperbaharui',
            'id' => $request->id,
            'name' => $request->name
        ]);
    }

    public function deleteBtn($id)
    {
        $position = Position::find($id);

        return response()->json([
            'id' => $position->id,
            'name' =>$position->name
        ]);
    }

    public function delete(Request $request)
    {
        $position = Position::find($request->id);
        $position->delete();

        return response()->json([
            'status' => 'Data berhasil dihapus'
        ]);
    }
}
