<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;


class FolderController extends Controller
{
    public function showAllFolders()
    {
        return response()->json(Folder::all());
    }

    public function showOneFolder($id)
    {
        return response()->json(Folder::find($id));
    }

    public function create(Request $request)
    {
        $Folder = Folder::create($request->all());

        return response()->json($Folder, 201);
    }

    public function update($id, Request $request)
    {
        $Folder = Folder::findOrFail($id);
        $Folder->update($request->all());

        return response()->json($Folder, 200);
    }

    public function delete($id)
    {
        Folder::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
