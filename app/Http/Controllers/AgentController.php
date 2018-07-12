<?php

namespace App\Http\Controllers;

use App\Agent;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Http\Controllers\HomeController;

class AgentController extends HomeController
{
    public function __construct() {

        parent::__construct();
        $this->template ='agent';
        session()->put('postreq','');
    }

    public function show(){
        if(Auth::user()->roles()->first()->name!='admin'){
            return redirect(route('home'));
        }
        $this->form=view('form.agentshow',['agents'=>Agent::all()]);
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="AGENT SHOW";
        return $this->renderOutput();
    }

    public function addform(){
        if(Auth::user()->roles()->first()->name!='admin'){
            return redirect(route('home'));
        }
        session()->put('datetime',date("Y-m-d H:i:s"));
        $this->form=view('form.agentadd');
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="AGENT ADD";

        return $this->renderOutput();
    }
    public function save(Request $request){
        if(Auth::user()->roles()->first()->name!='admin'){
            return redirect(route('home'));
        }
        if(session('postreq')==session('datetime')){

            return redirect(route('show_agent'));
        }else {
            session()->put('postreq',session('datetime'));
        }
        //dd(1);
        if(!empty(session('change_id'))){
            if($request->has('delete')){
                Agent::where('id',session('change_id'))->delete();
                return redirect(route('show_agent'));
            }
            $this->validate($request, [
                'profit_with_insurance'=>'required|integer|min:0|max:99',
                'profit_without_insurance'=>'required|integer|min:0|max:99',
            ]);
            DB::table('agents')->where('id','=',$request->input('id'))->update([
                'info' => $request->input('info'),
                'profit_with_insurance' => $request->input('profit_with_insurance'),
                'profit_without_insurance' => $request->input('profit_without_insurance'),
            ]);
            session()->put('change_id','');
            return redirect(route('show_agent'));
        }else {
            $this->validate($request, [
            'name' => 'required|max:255|unique:agents,name',
                'profit_with_insurance'=>'required|integer|min:0|max:99',
                'profit_without_insurance'=>'required|integer|min:|max:99',
              ]);
            Agent::create([
                'name'=>$request->input('name'),
                'info' =>$request->input('info'),
                'profit_with_insurance' =>$request->input('profit_with_insurance'),
                'profit_without_insurance' =>$request->input('profit_without_insurance'),
            ]);
            //session()->flush();
            return redirect(route('show_agent'));
        }
    }
    public function change(){
        if(Auth::user()->roles()->first()->name!='admin'){
            return redirect(route('home'));
        }
        // session()->flush();
        $btype=false;
        if(isset($_POST['id'])) {
            session()->put('change_id',$_POST['id']);
            session()->put('datetime',date("Y-m-d H:i:s"));
        }
        $btype=Agent::all()->where('id','=',session('change_id'))->first();
        if($btype) {
            session()->put('old.name', $btype->name);
            session()->put('old.info', $btype->info);
            session()->put('old.profit_with_insurance', $btype->profit_with_insurance);
            session()->put('old.profit_without_insurance', $btype->profit_without_insurance);

            $this->form=view('form.agentchange',['agent'=> $btype->id]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="AGENT CHANGE";

            return $this->renderOutput();
        }else return redirect(route('home'));
    }
    //
}
