<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Accessories extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded=['id'];
    //
}
