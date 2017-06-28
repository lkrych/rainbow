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
    public function run()
    {
      $faker = Faker\Factory::create();
      $colors = array('red','blue','yellow','green','purple','orange', 'yellow-green', 'blue-green', 'blue-violet', 'red-violet', 'red-orange', 'yellow-orange');
      //delete all friendships and users
      DB::table('users')->delete();
      DB::table('friends_users')->delete();
      //create new users
      $user_array = array();
      for($i = 0; $i < 10; $i++){
        array_push($user_array,
                 ['name'=>$faker->name,
                  'email'=>$faker->unique()->email,
                  'favorite_color' => $colors[rand(0,count($colors) - 1)],
                  'password'=>'']
          );
      }

      //reseed friendships by looping through each user and giving them three friends
      // foreach($user_array as $user):
      //   for($i = 0; $i < 3; $i++){
      //     $friend = $user_array[rand(0,count() - 1)];
      //     $user->addFriend($friend);
      //   }
      // endforeach;
      //reseed database with users
      foreach($user_array as $user):
        User::create($user);
      endforeach;

    }
}
