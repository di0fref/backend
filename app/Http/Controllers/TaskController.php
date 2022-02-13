<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    function getAll(\Illuminate\Http\Request $request){

        $tasksLists = TaskList::all();

        foreach ($tasksLists as $tasksList) {
            $tasksList->todos = Task::where("user_id", Auth::id())
                ->where("task_list_id", $tasksList->id)->get();
        }

        return response()->json(
            $tasksLists
        );

    }
    function create(\Illuminate\Http\Request $request){

        $task = Task::create(
            [
                "user_id" => Auth::id(),
                "name_" => "",//$request->text,
                "text" => $request->text,
                "task_list_id" => $request->task_list_id,
            ],
        );
        return response()->json($task, 201);

    }
    function update($id, \Illuminate\Http\Request $request){
        $task = Task::findOrFail($id);
        $task->update($request->all());

        return response()->json($task, 200);
    }
}
