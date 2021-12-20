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

    /* Special */
    $router->get('notes/bookmarks', ['uses' => 'NoteController@bookmarks']);
    $router->get('notes/folder/{id}', ['uses' => 'NoteController@folder']);
    $router->get('notes/trash', ['uses' => 'NoteController@getTrash']);
    /* End Special*/


    $router->get('notes', ['uses' => 'NoteController@showAllNotes']);
    $router->get('notes/{id}', ['uses' => 'NoteController@showOneNote']);
    $router->post('notes', ['uses' => 'NoteController@create']);
    $router->delete('notes/{id}', ['uses' => 'NoteController@delete']);
    $router->put('notes/{id}', ['uses' => 'NoteController@update']);


    $router->get('folders', ['uses' => 'FolderController@showAllFolders']);
    $router->get('folders/{id}', ['uses' => 'FolderController@showOneFolder']);
    $router->post('folders', ['uses' => 'FolderController@create']);
    $router->delete('folders/{id}', ['uses' => 'FolderController@delete']);
    $router->put('folders/{id}', ['uses' => 'FolderController@update']);

    /* Special */
    $router->get('folders/parent/{id}', ['uses' => 'FolderController@parent']);
    $router->get('folders/p/{id}', ['uses' => 'FolderController@p']);
    /* And Special */


    $router->get('recents', ['uses' => 'RecentController@showAllRecents']);
    $router->get('recents/{id}', ['uses' => 'RecentController@showOneRecent']);
    $router->post('recents', ['uses' => 'RecentController@create']);
    $router->delete('recents/{id}', ['uses' => 'RecentController@delete']);
    $router->put('recents/{id}', ['uses' => 'RecentController@update']);
});
