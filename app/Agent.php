<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Agent extends Model
{

    use SoftDeletes;

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    //

    protected $guarded=['id'];
    public function rental(){
        return $this->belongsTo('App\Rental');
    }

}
