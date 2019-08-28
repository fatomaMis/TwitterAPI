<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
{
    return $this->belongsToMany('App\User', 'action_log', 'following_id', 'follower_id')
        ->select('id', 'name', 'email');
}


public function following()
{
    return $this->belongsToMany('App\User', 'action_log', 'follower_id', 'following_id')
        ->select('id', 'name', 'email');
}

public function userTweet(){
    return $this->belongsToMany('App\Tweet', 'action_log', 'follower_id', 'following_id')
        ->select('id', 'name', 'email');
}

}
