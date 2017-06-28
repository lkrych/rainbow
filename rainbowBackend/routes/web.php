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

//helper function to format JSON for Ember
function formatJSON($data, $type) {
  $json = array('data' => array());
  foreach($data as $dataItem):
    array_push($json['data'], array( 'type' => $type,
                                   'id' => $dataItem->id,
                                   'attributes' => $dataItem));
  endforeach;
  return $json;
}

Route::get('/testdata',  function(Illuminate\Http\Request $request){

  //pull userCount from queryString
  $userCount = (int)$request->query('userCount');

  Artisan::call('db:seedCustom', ['userCount' => $userCount]);
});

//fetches all Users from the users table and returns each user in JSON
Route::get('/users', function () {
    $users = App\User::all();
    //grab all friends from friendship table
    foreach($users as $user):
      $friends = $user->friends;
    endforeach;
    return formatJSON($users, 'users');
});

Route::get('/user/{userid}/{color}', function($userid, $color) {
  $user = App\User::find($userid);
  $user->updateColor($color);
  return $user;
});

Route::get('/user/{userid}/{friendid}', function($userid, $friendid) {
  $user = App\User::find($userid);
  $user->removeFriend($friendid);
  return $user;
});

Route::get('/user/{userid}', function ($userid) {
    $user = App\User::find($userid);
    //fetch friends
    $friends = $user->friends;

    return $user;
});
