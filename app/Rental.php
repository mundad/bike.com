<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $guarded=['id'];
    public  function user(){
        return $this->hasMany('App\User');
    }
    public  function user_get(){
        return $this->belongsTo('App\User_get','user_get_id','id');
    }
    public function sale(){
        return $this->hasone('App\Sale','rental_id','id');
    }
    public function acsor(){
        return $this->hasone('App\Accessories','rental_id','id');
    }
    public  function rental_bike(){
        return $this->belongsTo('App\Rental_bike');
    }
    //
}
