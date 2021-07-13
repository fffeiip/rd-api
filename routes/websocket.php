<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {
    // called while socket on
//    $request->user();
//    auth()->user();
//    ['uses' => 'UserController@authenticate']
    echo "opaaa";
    $websocket->emit('message', 'welcome');
})
//->middleware('UserController@authenticate')
;

Websocket::broadcast()->emit('message', 'this is a test');

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
});

Websocket::on('example', function ($websocket, $data) {
    $websocket->emit('message', $data);
});

Websocket::on('test', 'ExampleController@method');
