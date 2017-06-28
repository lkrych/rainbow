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

Route::get('/testdata',  function(Illuminate\Http\Request $request){

  //pull userCount from queryString
  $userCount = (int)$request->query('userCount');

  Artisan::call('db:seedCustom', ['userCount' => $userCount]);
});

//fetches all Users from the users table and returns each user in JSON
Route::get('/', function () {
    $users = App\User::all();
    return $users;
});

Route::get('/{userid}/{color}', function($userid, $color) {
  $user = App\User::find($userid);
  $user->updateColor($color);
  return $user;
});

Route::get('/{userid}/{friendid}', function($userid, $friendid) {
  $user = App\User::find($userid);
  $user->removeFriend($friendid);
  return $user;
});

Route::get('/{userid}', function ($userid) {
    $user = App\User::find($userid);
    return $user;
});
