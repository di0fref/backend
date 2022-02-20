<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {
//$router->group(['prefix' => 'api'], function () use ($router) {


    $router->get("tasks", ["uses" => "TaskController@getAll"]);
    $router->put("tasks/{id}", ["uses" => "TaskController@update"]);
    $router->post("tasks", ["uses" => "TaskController@create"]);
    $router->delete("tasks/{id}", ["uses" => "TaskController@delete"]);

    $router->get("tasklists", ["uses" => "TaskListController@getAll"]);
    $router->put("tasklists/{id}", ["uses" => "TaskListController@update"]);
    $router->post("tasklists", ["uses" => "TaskListController@create"]);


    /* Special */
    $router->get('notes/bookmarks', ['uses' => 'NoteController@bookmarks']);
    $router->post('search', ['uses' => 'NoteController@search']);
    $router->get('notes/trash', ['uses' => 'NoteController@getTrash']);
    /* End Special */


    $router->get('notes', ['uses' => 'NoteController@showAllNotes']);
    $router->get('notes/{id}', ['uses' => 'NoteController@showOneNote']);
    $router->post('notes', ['uses' => 'NoteController@create']);
    $router->delete('notes/{id}', ['uses' => 'NoteController@delete']);
    $router->put('notes/{id}', ['uses' => 'NoteController@update']);
    $router->get("notes/folder/{id}", ["uses" => "NoteController@showAllNotesInFolder"]);


    $router->get('folders', ['uses' => 'FolderController@showAllFolders']);
    $router->get('folders/{id}', ['uses' => 'FolderController@showOneFolder']);
    $router->post('folders', ['uses' => 'FolderController@create']);
    $router->delete('folders/{id}', ['uses' => 'FolderController@delete']);
    $router->put('folders/{id}', ['uses' => 'FolderController@update']);

    /* Special */ //    $router->get('folders/parent/{id}', ['uses' => 'FolderController@parent']);
    $router->get('folders/p/{id}', ['uses' => 'FolderController@p']);
    $router->get('tree', ['uses' => 'FolderController@tree']);

    /* And Special */


    $router->get('recents', ['uses' => 'RecentController@showAllRecents']);
    $router->post('recents', ['uses' => 'RecentController@create']);

//    $router->get('users', ['uses' => 'UserController@showAllNotes']);
    $router->get('users/{id}', ['uses' => 'UserController@showOneNote']);
    $router->post('users', ['uses' => 'UserController@create']);
    $router->post('users/validate', ['uses' => 'UserController@validateUser']);
    $router->post('users/login', ['uses' => 'UserController@login']);
    $router->delete('users/{id}', ['uses' => 'UserController@delete']);
    $router->put('users/{id}', ['uses' => 'UserController@update']);
});
$router->post('api/users/login', ['uses' => 'UserController@login']);
$router->post('api/users/signup', ['uses' => 'UserController@login']);
$router->get('api/notes/shared/{id}', ['uses' => 'NoteController@showOneSharedNote']);


