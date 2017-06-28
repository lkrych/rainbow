<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//fetches all Users from the users table and returns each user in JSON
Route::get('/', function () {

    $users = App\User::all();
    return $users;
});

Route::get('/{userid}', function ($userid) {
    $user = App\User::find($userid);
    return $user;
});
