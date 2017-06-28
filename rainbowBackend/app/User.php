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
      $this->update(['favorite_color' => $color]);
    }

    public function friends()
  	{
  		return $this->belongsToMany('User', 'friends_users', 'user_id', 'friend_id');
  	}

    //only use this function for TEST route
    public function addFriend(User $user)
  	{
  		$this->friends()->attach($user->id);
  	}

  	public function removeFriend(User $user)
  	{
  		$this->friends()->detach($user->id);
  	}


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
