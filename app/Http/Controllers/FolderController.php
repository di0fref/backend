<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FolderController extends Controller
{
    public function buildTree( $elements, $parentId = 0) {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->id);
                if ($children) {
                    $element->items = $children;
                }else{
                    $element->items = [];
                }
                $element->items = array_merge(
                    $element->items,
                    DB::table("notes")
                        ->where("folder_id", $element->id)
                        ->where("deleted", "0")
                        ->where("user_id", Auth::id())
                        ->get(["*",  DB::raw("concat('note') as type")])
                        ->toArray());

                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function tree(\Illuminate\Http\Request $request)
    {
        $folders = DB::table("folders")
            ->where("user_id", Auth::id())
            ->get(["*",  DB::raw("concat('folder') as type")]);
        $tree = $this->buildTree($folders);


        $notes = DB::table("notes")
            ->where("folder_id", "0")
            ->where("deleted", "0")
            ->where("user_id", Auth::id())
            ->get(["*", DB::raw("concat('note') as type")])
            ->toArray();

        $data = array_merge($tree, $notes);


        return response()->json($data);
    }

    public function showAllFolders(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("folders")
                ->where("user_id", Auth::id())
                ->get()
        );
    }


    public function showOneFolder($id, \Illuminate\Http\Request $request)
    {
        return response()->json(Folder::find($id));
    }
    public function create(Request $request)
    {
        $Folder = Folder::create(
            [
                "user_id" => Auth::id(),
                "name" => $request->name,
                "parent_id" => $request->parent_id,
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
