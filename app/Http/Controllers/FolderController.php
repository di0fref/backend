<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FolderController extends Controller
{
    public function showAllFolders()
    {
        return response()->json(Folder::all());
    }

    public function parent($id)
    {
        //"SELECT id, name as label, concat('folder') as type from folders where parent_id = ?",
        return response()->json(

            DB::table("folders")
                ->where("parent_id", $id)
                ->get(
                    ["*", DB::raw("concat('folder') as type")])
            );

    }

    public function showOneFolder($id)
    {
        return response()->json(Folder::find($id));
    }

    public function p($id)
    {
        // SELECT parent_id, name as label, concat('folder') as type from folders where id = ?
        return response()->json(

            DB::table("folders")
                ->where("id", $id)
                ->get(["parent_id", "name as label", DB::raw("concat('folder') as type")])
        );

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
