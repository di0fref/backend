<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Note;
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
                  $count = Note::where("folder_id", $element->id)
                        ->where("deleted", "0")
                        ->where("user_id", Auth::id())
                        ->count();

                $element->doc_count = $count;

//                $element->items = array_merge(
//                    Note::where("folder_id", $element->id)
//                        ->where("deleted", "0")
//                        ->where("user_id", Auth::id())
//                        ->orderBy("name")
//                        ->get(["*",  DB::raw("concat('note') as type")])
//                        ->toArray()
//                    ,$element->items);
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function tree(\Illuminate\Http\Request $request)
    {
        $folders = Folder::where("user_id", Auth::id())
            ->orderBy("name")
            ->get(["*",  DB::raw("concat('folder') as type")]);
        $tree = $this->buildTree($folders);


        $notes = Note::where("folder_id", "0")
            ->where("deleted", "0")
            ->where("user_id", Auth::id())
            ->orderBy("name")
            ->get(["*", DB::raw("concat('note') as type")])
            ->toArray();

        $data = array_merge($notes, $tree);


        return response()->json($tree);
    }

    public function showAllFolders(\Illuminate\Http\Request $request)
    {
        return response()->json(

            Folder::where("user_id", Auth::id())->get()
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
    public function p($id, \Illuminate\Http\Request $request)
    {
        // SELECT parent_id, name as label, concat('folder') as type from folders where id = ?
        return response()->json(

           Folder::where("id", $id)
                ->where("user_id", Auth::id(),)
                ->get(["parent_id", "name as label", DB::raw("concat('folder') as type")])
        );

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
