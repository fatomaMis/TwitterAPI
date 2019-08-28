<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function followers()
{
    return $this->belongsToMany('App\User', 'follower_following', 'following_id', 'follower_id')
        ->select('id', 'username', 'name','uid');
}


public function following()
{
    return $this->belongsToMany('App\User', 'follower_following', 'follower_id', 'following_id')
        ->select('id', 'username', 'name','uid');
}
}
