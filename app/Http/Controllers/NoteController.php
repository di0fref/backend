<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NoteController extends Controller
{
    public function showAllNotes(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", 0)
                ->where("user_id", $request->header("Credentials"))
                ->get()
        );
    }


    public function getTrash(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("deleted", 1)
                ->where("user_id", $request->header("Credentials"))
                ->orderBy("name")
                ->get()
        );

    }


    public function bookmarks(\Illuminate\Http\Request $request)
    {
        return response()->json(

            DB::table("notes")
                ->where("bookmark", 1)
                ->where("user_id", $request->header("Credentials"))
                ->where("deleted", 0)
                ->orderBy("name")
                ->get()
        );

    }

    function folder($id, \Illuminate\Http\Request $request)
    {
        return response()->json(
            DB::table("notes")
                ->where("folder_id", $id)
                ->where("deleted", 0)
                ->where("user_id", $request->header("Credentials"))
                ->get(["*", "name as label", DB::raw("concat('note') as type")])
        );
    }

    public function showOneNote($id, \Illuminate\Http\Request $request)
    {
        return response()->json(
            DB::table("notes")
                ->where("user_id", $request->header("Credentials"))
                ->where("deleted", 0)
                ->where("id", $id)
                ->get()
                ->first()
        );
    }

    public function create(Request $request)
    {
        $Note = Note::create($request->all());

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
