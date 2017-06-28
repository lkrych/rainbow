<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    public function updateColor($color)
    {
      $this->update(['favoritecolor' => $color]);
    }

    public function friends()
  	{
  		return $this->belongsToMany('App\User', 'friends_users', 'user_id', 'friend_id');
  	}

    //only use this function for TEST route
    public function addFriend($user)
  	{

      $friends = $this->friends();
      //don't allow people to be friends with themselves;
      if($user->id !== $this->id ){
        try{
  		    $friends->attach($user->id);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
          }

        }
  	}

  	public function removeFriend($user)
  	{
  		$this->friends()->detach($user->id);
  	}


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'favoritecolor'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
