<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FolderController extends Controller
{
    public function showAllFolders(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("folders")
                ->where("user_id", $request->header("uid"))
                ->get()
        );
    }

    public function parent($id, \Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("folders")
                ->where("parent_id", $id)
                ->where("user_id", $request->header("uid"))
                ->get(
                    ["*", DB::raw("concat('folder') as type")])
        );

    }

    public function showOneFolder($id, \Illuminate\Http\Request $request)
    {
        return response()->json(Folder::find($id));
    }

    public function p($id, \Illuminate\Http\Request $request)
    {
        // SELECT parent_id, name as label, concat('folder') as type from folders where id = ?
        return response()->json(

            DB::table("folders")
                ->where("id", $id)
                ->where("user_id", $request->header("uid"))
                ->get(["parent_id", "name as label", DB::raw("concat('folder') as type")])
        );

    }

    public function create(Request $request)
    {
        $Folder = Folder::create(
            [
                "user_id" => $request->header("uid"),
                "name" => $request->name,
                "parent_id" => $request->parent_id
            ],
        );

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
