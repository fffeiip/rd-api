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

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('users/{id}', ['uses' => 'UserController@show']);
    $router->post('users', ['uses' => 'UserController@create']);
    $router->delete('users/{id}', ['uses' => 'UserController@delete']);
    $router->put('users/{id}', ['uses' => 'UserController@update']);

    $router->get('dynamics/{id}', ['uses' => 'DynamicsController@show']);
    $router->post('dynamics', ['uses' => 'DynamicsController@create']);
    $router->get('dynamics', ['uses' => 'DynamicsController@showAll']);
    $router->delete('dynamics/{id}', ['uses' => 'DynamicsController@delete']);
    $router->put('dynamics/{id}', ['uses' => 'DynamicsController@update']);

    $router->get('dynamics/user/{id}', ['uses' => 'LinkDynamicsUserController@showDynamicsByUser']);
    $router->get('dynamics/created/user/{id}', ['uses' => 'LinkDynamicsUserController@showUserCreatedDynamics']);
    $router->post('dynamics/register', ['uses' => 'LinkDynamicsUserController@create']);
    $router->delete('dynamics/register/{id}', ['uses' => 'LinkDynamicsUserController@delete']);
    $router->get('dynamics/register/{id}', ['uses' => 'LinkDynamicsUserController@show']);

    $router->get('team/{id}', ['uses' => 'TeamController@show']);
    $router->post('team', ['uses' => 'TeamController@create']);
    $router->delete('team/{id}', ['uses' => 'TeamController@delete']);
    $router->put('team/{id}', ['uses' => 'TeamController@update']);

});
