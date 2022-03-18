<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
    public function threadUsers()
    {
        return $this->hasMany('App\UserThread','thread_id','id');
    }
    public function otherUser()
    {
        return $this->hasone('App\UserThread','thread_id','id');
    }
//    public function threadUsers()
//    {
//        return $this->hasManyThrough('App\User','App\UserThread','thread_id','id','id','id');
//    }
    public function messages()
    {
        return $this->hasMany('App\Message','thread_id','id');
    }
    public function latestMessage()
    {
        return $this->hasOne('App\Message','thread_id','id')->latest();
    }
}
