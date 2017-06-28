<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($userCount = 20)
    {
      $faker = Faker\Factory::create();
      $colors = array('red','blue','yellow','green','purple','orange', 'yellow-green', 'blue-green', 'blue-violet', 'red-violet', 'red-orange', 'yellow-orange');
      //delete all friendships and users
      DB::table('friends_users')->delete();
      DB::table('users')->delete();

      //create new users
      $user_array = array();
      for($i = 0; $i < $userCount; $i++){
        array_push($user_array,
                 ['name'=> $faker->name,
                  'email'=> $faker->unique()->email,
                  'favoritecolor' => $colors[rand(0,count($colors) - 1)],
                  'password'=>'']
          );
      }
      //reseed database with users
      foreach($user_array as $user):
        User::create($user);
      endforeach;
      //reseed friendships by looping through each user and giving them a random number of friends
      $new_users = User::all();
      foreach($new_users as $user):
          $friendCount = rand(0,50);
          $friends = array();

          for($i = 0; $i < $friendCount; $i++){
            $friend = $new_users[rand(0,count($new_users) - 1)];
            if(!array_key_exists($friend->id, $friends)){
              $user->addFriend($friend);
            }
            $friends[$friend->id] = true;
          }
      endforeach;
    }
}
