<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded=['id'];

    public  function rental(){
        return $this->belongsTo('App\Rental','rental_id','id');
    }
    //
}
