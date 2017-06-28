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
Route::post('/testdata',  function(Illuminate\Http\Request $request){
  //this route logic is a little complicated, and could have been refactored into a controller. But since it is such a small app, I'm going to do without.

  //pull userCount from queryString
  $queryArray = $request->all();
  $seedCount = $queryArray[0];

  // clean and re-initialize database using userCount param
  $faker = Faker\Factory::create();
  $colors = array('red','blue','yellow','green','purple','orange', 'yellow-green', 'blue-green', 'blue-violet', 'red-violet', 'red-orange', 'yellow-orange');
  //delete all friendships and users
  DB::table('users')->delete();
  DB::table('friends_users')->delete();
  //create new users
  $user_array = array();
  for($i = 0; $i < 10; $i++){
    $user_array.push(
             ['name'=>$faker->name,
              'email'=>$faker->unique()->email,
              'favorite_color' => $colors[rand(0,count($colors) - 1)],
              'password'=>'']
      );
  }

  //reseed friendships by looping through each user and giving them three friends
  foreach($user_array as $user):
    for($i = 0; $i < 3; $i++){
      $friend = $user_array[rand(0,count() - 1)];
      $user->addFriend($friend);
    }
  endforeach;
  //reseed database with users
  foreach($user_array as $user):
    DB::table('users')->insert($user);
  endforeach;

  //redirect to index
  return redirect('/');
});
