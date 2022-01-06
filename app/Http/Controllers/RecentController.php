<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Recent;
use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class RecentController extends Controller
{

    public function showAllRecents(\Illuminate\Http\Request $request)
    {
        return response()->json(

            Recent::where("deleted", "0")
                ->where("recents.user_id", Auth::id())
                ->leftJoin("notes", "notes.id", "=", "recents.note_id")
                ->leftJoin("folders", "notes.folder_id", "=", "folders.id")
                ->get([
                    "notes.name as note_name",
                    "notes.id as note_id",
                    "bookmark",
                    "deleted",
                    "folders.name as folder",
                    "recents.updated_at as accessed_on"
                ])
        );
    }

    public function create(Request $request)
    {
        $Recent = Recent::updateOrCreate(
            [
                "note_id" => $request->input("note_id"),
                "user_id" => Auth::id()
            ],
        )->touch();

        return response()->json($Recent);

    }
}
