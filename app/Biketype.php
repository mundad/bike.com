<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Biketype extends Model
{

    use SoftDeletes;

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    protected  $guarded=['id'];
    public function rental_bike(){
        return $this->belongsTo('App\Rental_bike');
    }
    //
}
