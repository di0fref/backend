<?php

namespace App\Http\Controllers;

use App\Models\Recent;
use Illuminate\Http\Request;


class RecentController extends Controller
{
    public function showAllRecents()
    {
        return response()->json(Recent::all());
    }

    public function showOneRecent($id)
    {
        return response()->json(Recent::find($id));
    }

    public function create(Request $request)
    {
        $Recent = Recent::create($request->all());

        return response()->json($Recent, 201);
    }

    public function update($id, Request $request)
    {
        $Recent = Recent::findOrFail($id);
        $Recent->update($request->all());

        return response()->json($Recent, 200);
    }

    public function delete($id)
    {
        Recent::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
