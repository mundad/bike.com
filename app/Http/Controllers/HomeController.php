<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $vars = array();
    protected $menu;
    protected $form;
    protected $title;
    protected $template;

    public function __construct()
    {
        $this->middleware('auth');
        $this->menu=view('layouts.menu');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $this->vars=array_add($this->vars,'menu',$this->menu);
       // dd(Auth::user()->roles->all()) for policy;
        $this->title="home page";
        $this->vars = array_add($this->vars,'title',$this->title);
        return view('home',$this->vars);
    }
    protected function renderOutput() {
        //dd($this->menu);
        $this->vars=array_add($this->vars,'menu',$this->menu);
        $this->vars = array_add($this->vars,'title',$this->title);


        return view($this->template)->with($this->vars);
    }

}















