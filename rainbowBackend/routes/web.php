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

Route::put('/{userid}/{color}', function($userid, $color) {
  $user = App\User::find($userid);
  $user->updateColor($color);
  return $user;
});

Route::delete('/{userid}/{friendid}', function($userid, $friendid) {
  $user = App\User::find($userid);
  $user->removeFriend($friendid);
  return $user;
});

// Route::get('/testdata', 'UsersController#seed');
Route::get('/testdata',  function(Illuminate\Http\Request $request){

  //pull userCount from queryString
  $queryArray = $request->all();
  $seedCount = $queryArray[0];

  Artisan::call('db:seed');
  // clean and re-initialize database using userCount param

  //redirect to index
  return redirect('/');
});


Route::get('/reseed', function(){
  Artisan::call('db:seed');
  return redirect('/');
});
