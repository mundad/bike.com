<?php

namespace App\Http\Controllers;

use App\Biketype;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\HomeController;

class BiketypeController extends HomeController
{
    public function __construct() {
        parent::__construct();
        $this->template ='biketype';
        session()->put('postreq','');
    }

    public function show(){
        $this->form=view('form.biketypeshow',['biketypes'=>Biketype::all()]);
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="BIKE TYPE SHOW";
        return $this->renderOutput();
    }

    public function addform(){
        session()->put('datetime',date("Y-m-d H:i:s"));
        $this->form=view('form.biketypeadd');
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="BIKE TYPE ADD";

        return $this->renderOutput();
    }
    public function save(Request $request){
        if(session('postreq')==session('datetime')){

            return redirect(route('show_biketype'));
        }else {
            session()->put('postreq',session('datetime'));
        }
        if(!empty(session('change_id'))){
            if($request->has('delete')){
                Biketype::where('id',session('change_id'))->delete();
                return redirect(route('show_biketype'));
            }
            $this->validate($request, [
                'price_h' => 'required|numeric|min:0',
                'price_h_2' => 'required|numeric|min:0',
                'price_h_3' => 'required|numeric|min:0',
                'price_h_5' => 'required|numeric|min:0',
                'price_d' => 'required|numeric|min:0',
                'insurance' => 'required|numeric|min:0'
            ]);
            DB::table('biketypes')->where('id','=',$request->input('id'))->update([
                'info' => $request->input('info'),
                'price_h' => $request->input('price_h'),
                'price_h_2' => $request->input('price_h_2'),
                'price_h_3' => $request->input('price_h_3'),
                'price_h_5' => $request->input('price_h_5'),
                'price_d' => $request->input('price_d'),
                'insurance' => $request->input('insurance')
            ]);
            session()->put('change_id','');
            return redirect(route('show_biketype'));
        }else {
            $this->validate($request, [
                'name' => 'required|max:255|unique:biketypes,name',
                'price_h' => 'required|numeric|min:0',
                'price_h_2' => 'required|numeric|min:0',
                'price_h_3' => 'required|numeric|min:0',
                'price_h_5' => 'required|numeric|min:0',
                'price_d' => 'required|numeric|min:0',
                'insurance' => 'required|numeric|min:0'
            ]);
            Biketype::create([
                'name'=>$request->input('name'),
                'info' =>$request->input('info'),
                'price_h'=>$request->input('price_h'),
                'price_h_2'=>$request->input('price_h_2'),
                'price_h_3'=>$request->input('price_h_3'),
                'price_h_5'=>$request->input('price_h_5'),
                'price_d'=>$request->input('price_d'),
                'insurance'=>$request->input('insurance'),
            ]);
            return redirect(route('show_biketype'));
        }
    }
    public function change(){
        session()->put('datetime',date("Y-m-d H:i:s"));
       // session()->flush();
        if(isset($_POST['id'])) {
            session()->put('change_id',$_POST['id']);
        }
        $btype=false;
        $btype=Biketype::all()->where('id','=',session('change_id'))->first();
        if($btype) {
            session()->put('old.name', $btype->name);
            session()->put('old.info', $btype->info);
            session()->put('old.price_h', $btype->price_h);
            session()->put('old.price_h_2', $btype->price_h_2);
            session()->put('old.price_h_3', $btype->price_h_3);
            session()->put('old.price_h_5', $btype->price_h_5);
            session()->put('old.price_d', $btype->price_d);
            session()->put('old.insurance', $btype->insurance);

            $this->form=view('form.biketypechange',['biketype'=> $btype->id]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="BIKE TYPE CHANGE";

            return $this->renderOutput();
        }else return redirect(route('home'));

    }
    //
}
























