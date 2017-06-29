# Rainbow connection
## Everyone has a favorite color, what is yours?

### Overview

Rainbow connection is a social network that keeps things simple. You only need to disclose your name and your favorite color.

With an exceedingly usable interface, Rainbow Connection is fast becoming one of the most essential ways to share on the web. Join Rainbow Connection and add a little more color into your life.

### Technical overview

Rainbow Connection is a sample application built with a PHP laravel/ MySQL backend and an Ember.js frontend. The project was created in two days with no previous experience in either technology. Let's talk through some of the features, and we can discuss the engineering challenges and insights gained in this engineering sprint.

### File Structure and DB schema

The project is separated into frontend and backend files. This clean split makes it easy to cleave off the components that one might use in the future. Say we transition into a rails backend, all we will need to do to plug it in is change the proxy of the ember server. Likewise, if we decide to move onto a React frontend, we can easily point it to our Laravel server.

There are two main tables used in the MySQL database, the users table and the friendships table. The users table holds individual records for each user, their name, and favorite color. The friendships table represents many-to-many relationships between users, and is composed of two integer fields, user_id, and friend_id, which point to the users table.

### Features

#### Index page

![Index page](https://github.com/lkrych/rainbow/blob/master/rainbowEmber/app/styles/images/rainbowIndex.png?raw=true)


The index page is the heart of Rainbow connection, it displays currently signed up users, their favorite colors and links to their friends. This data is being retrieved from the Laravel backend and has some surprising headaches associated with it. Ember does not like the format of the JSON that is returned by default from the Laravel server, so I needed to create a helper function that injects the proper formatting into the default JSON object.

```php
// rainbowBackend/routes/web.php

function formatUsersJSON($data, $type) {
  $json = array('data' => array());
  foreach($data as $dataItem):
    array_push($json['data'], array( 'type' => $type,
                                   'id' => $dataItem->id,
                                   'attributes' => $dataItem));
  endforeach;
  return $json;
}

```

At the time of writing, I am at work on the infinite pagination feature of the application. To make an unpleasant analogy, if the index page is the heart of the application, like many hearts, it just stops and freezes under heavy load. I hope to get this feature off the ground soon.

#### User view

![User view](https://github.com/lkrych/rainbow/blob/master/rainbowEmber/app/styles/images/userview.png?raw=true)

Clicking on any name on the index page leads to the user view. The user view displays a user's favorite color, and a list of all their friends. Currently you can delete a user's friends using a deleteFriend action that is caught by the user Route. This action dispatches an AJAX request and removes the friendship from the Friendship table in the backend.

```Javascript
//rainbowEmber/app/routes/user.js

import Ember from 'ember';

export default Ember.Route.extend({
  model(userId){
    return this.store.findRecord('user', parseInt(userId.userId) );
  },
  actions: {
    deleteFriend(userId, friendId){
      Ember.$.getJSON(`${userId}/${friendId}`);
      this.refresh();
      this.transitionTo('index');
    },
    updateColor(userId, color){
      Ember.$.getJSON(`${userId}/color/${color}`);
      this.refresh();
      this.transitionTo('index');
    }
  }
});
```

Likewise, you will soon be able to change a user's favorite color by selecting a new color in the drop down menu. The action is already setup in the user's route, it just needs be wired into the drop down menu.

#### Testdata endpoint

Lastly, and perhaps most interesting from an engineering perspective is the testdata URL endpoint of the application. Given a URL like this 'testdata?userCount=15, the ember frontend will make an AJAX request to the server that will trigger a custom artisan command that will seed the database with userCount number of new user's with 0 to 50 new friendships and a random favorite color. Writing the custom artisan command took me a while to figure out as I have never actually made command-line calls from a server before. My implementation is rather elegant, a simple closure and works for large input. It is currently hamstrung by my lack of pagination but that will soon be fixed.

```php
//rainbowBackend/routes/console.php

Artisan::command('db:seedCustom {userCount}', function ($userCount) {
  $seeder = new UsersTableSeeder();
  $seeder->run((int)$userCount);
});


```
Custom artisan command

```php

//rainbowBackend/database/seeds/UsersTableSeeder

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run($userCount = 20)
    {
      $faker = Faker\Factory::create();
      $colors = array('red','blue','yellow','green','purple','orange', 'yellow-green', 'blue-green', 'blue-violet', 'red-violet', 'red-orange', 'yellow-orange');
      DB::table('friends_users')->delete();
      DB::table('users')->delete();

      $user_array = array();
      for($i = 0; $i < $userCount; $i++){
        array_push($user_array,
                 ['name'=> $faker->name,
                  'email'=> $faker->unique()->email,
                  'favoritecolor' => $colors[rand(0,count($colors) - 1)],
                  'password'=>'']
          );
      }
      foreach($user_array as $user):
        User::create($user);
      endforeach;

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

```
Database Seeding code

Let's do a brief overview of the project and  assess the successes and the failures of this implementation

## Requirements
1. Site should only use ajax beyond initial index page load **complete**
2. All endpoints should follow REST protocol **debatable**
3. Site should be developed using Laravel PHP and Ember.js **complete**
4. Domain should be "www.rainbowconnection.com".  In osx/linux you can edit your /etc/hosts file to point this domain to your local instance (recommend homestead or laradock). **unfinished, but should be an easy change**
5. All lists should be displayed using "infinite pagination".  Any list with more than 25 results should be paginated in this way.  Upon scrolling down, an additional 25 results should load at a time. **incomplete**
6. Color options include all primary, secondary & tertiary colors **complete**
7. Anywhere a user's favorite color appears, the text should be colored corresponding to the value. **complete**
8. Code should be well documented with appropriate comments. **complete**
9. Please include a top-level README.md explaining your major architectural decisions.  Most important requirement is shipping on time, so if you have to make feature cuts or take shortcuts in order to finish, please explain what trade-offs you made and why you chose them. **complete**

## Initial View (www.rainbowconnection.com)
* Displays a list of all users with three columns: [full name], [favorite color], [comma-separated list of full names of all connections] **complete**
* Favorite color text should be colored with the relevant color **complete**
* User's full name, and each connection name should be clickable.  Clicking should take you to User View page. **complete**

## User View (www.rainbowconnection.com/[userid])
* Displays a title with this user's full name and favorite color **complete**
* Displays a list of all user's connections with three columns: [full name], [favorite color], [remove button] **complete**
* Clicking a list item's remove button should remove that connection and update the current view. **complete**
* Clicking on the favorite color of the current user in the title bar should give a drop-down selection of colors.  Selecting a new color should update the current user's color. **almost complete**

## Test Endpoint (POST www.rainbowconnection.com/testdata)
* PARAMS: userCount - Integer between 1 and 1000000 **complete**
* This endpoint should clear the database, and populate it with a set of [userCount] users with randomly generated, human first and last names. **complete**
* Each user should have between 0 and 50 randomly generated connections. **complete**
* Each user should have a randomly generated favorite color. **complete**


## Interested in using rainbow connection?

Clone the repository and intialize both of the technologies! You should use composer for PHP, and NPM for ember. Have fun!
