<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biketype;
use App\Http\Controllers\HomeController;
use App\User_get;

class JsonSenderController extends HomeController
{
    public function __construct(){
        parent::__construct();
    }
    public function biketype(){
        return Biketype::all()->toJson();
    }

    public function user_get(Request $request){
        return User_get::where('phone','like',$request->input('phone').'%')->get()->toJson();
    }

    //
}
