<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class NoteController extends Controller
{

    public function search(\Illuminate\Http\Request $request)
    {
        $term = $request->input("term");

        return response()->json(

            Note::where("notes.deleted", "0")
                ->where("notes.user_id", Auth::id())
                ->where(function ($query) use ($term) {
                    $query->where("notes.name", "like", "%" . $term . "%")
                        ->orWhere("notes.text", "like", "%" . $term . "%");
                })
                ->leftJoin("folders", "notes.folder_id", "=", "folders.id")
                ->get(["text", "notes.name as name", "folders.name as folder_name", "notes.id as note_id", "folders.id as folder_id", "locked", "bookmark"])

        );
    }

    public function showAllNotes(\Illuminate\Http\Request $request)
    {
        return response()->json(

            Note::where("user_id", Auth::id())
                ->orderBy("updated_at", "desc")
                ->get()

        );
    }

    public function showAllNotesInFolder($id, \Illuminate\Http\Request $request)
    {
        return response()->json(

            Note::where("user_id", Auth::id())
               ->where("folder_id", $id)
                ->orderBy("updated_at", "desc")
                ->get()


        );

    }

    public function getTrash(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", "1")
                ->where("user_id", Auth::id())
                ->orderBy("updated_at", "desc")
                ->get()
        );

    }


    public function bookmarks(\Illuminate\Http\Request $request)
    {
        return response()->json(

            Note::where("bookmark", "1")
                ->where("deleted", "0")
                ->where("user_id", Auth::id())
                ->orderBy("name")
                ->get()
        );

    }

//    function folder($id, \Illuminate\Http\Request $request)
//    {
//        return response()->json(
//            DB::table("notes")
//                ->where("folder_id", $id)
//                ->where("deleted", 0)
//                ->where("user_id", $request->header("uid"))
//                ->get(["*", "name as label", DB::raw("concat('note') as type")])
//        );
//    }

    public function showOneNote($id, \Illuminate\Http\Request $request)
    {
        return response()->json(
            Note::where("deleted", "0")
                ->where("id", $id)
                ->where("user_id", Auth::id())
                ->get()
                ->first()
        );
    }
    public function showOneSharedNote($id, \Illuminate\Http\Request $request)
    {
        return response()->json(
            Note::where("id", $id)
                ->get()
                ->first()
        );
    }
    public function create(Request $request)
    {
        $Note = Note::create(
            [
                "user_id" => Auth::id(),
                "name_" => "",
                "text" => null,
                "folder_id" => $request->folder_id,
                "team_id" => ""
            ],
        );


        return response()->json($Note, 201);
    }

    public function update($id, Request $request)
    {
        $Note = Note::findOrFail($id);
        $Note->update($request->all());

        return response()->json($Note, 200);
    }

    public function delete($id, \Illuminate\Http\Request $request)
    {
        Note::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}
