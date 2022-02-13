<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;


class TaskListController extends Controller
{
    function getAll(\Illuminate\Http\Request $request){


    }
    function create(\Illuminate\Http\Request $request){

        $TaskList = TaskList::create(
            [
                "user_id" => Auth::id(),
                "name" => $request->name,
            ],
        );
        return response()->json($TaskList, 201);

    }
    function update($id, \Illuminate\Http\Request $request){
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json($task, 200);
    }
}
