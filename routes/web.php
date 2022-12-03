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

    $router->get("tasks", ["uses" => "TaskController@getAll"]);
    $router->post("tasks", ["uses" => "TaskController@create"]);

    $router->post("projects", ["uses" => "ProjectController@create"]);
    $router->get("projects", ["uses" => "ProjectController@getAll"]);


});
$router->post('api/users/login', ['uses' => 'UserController@login']);
$router->post('api/users/signup', ['uses' => 'UserController@login']);
$router->get('api/notes/shared/{id}', ['uses' => 'NoteController@showOneSharedNote']);


