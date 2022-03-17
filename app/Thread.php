<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //
//    public function threadUsers()
//    {
//        return $this->hasMany('App\UserThread','thread_id','id');
//    }
    public function threadUsers()
    {
        return $this->hasManyThrough('App\User','App\UserThread','thread_id','id','id','id');
    }
}
