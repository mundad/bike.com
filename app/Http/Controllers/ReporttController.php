<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;use DB;
use App\Http\Controllers\HomeController;
use App\Agent;
use App\Biketype;
use App\Rental;
use App\Rental_bike;
use App\User;
use App\User_get;
use App\Accessories;
use App\Sale;
use Auth;
use Validator;
class ReporttController extends HomeController
{
    public function __construct() {
        parent::__construct();
        $this->template ='report';
        session()->put('postreq','');
        session()->put('agentpaid_id','');
    }
    public function show(){
        if(Auth::user()->roles()->first()->name=='admin'){
            $rent=Rental::with('user_get','sale')->orderBy('created_at','desc')->take(20)->get();
            $this->form=view('form.reportshow',['rentalbikes'=>$rent]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="REPORT RENTAL BIKES SHOW";
            return $this->renderOutput();
        }else return redirect(route('show_rentalbike'));
    }
    public function search(Request $request){
        //dd(1);

        if(Auth::user()->roles()->first()->name=='admin'){
            if(!empty($request->input('phone'))&&empty($request->input('date'))){
                if(is_numeric($request->input('phone'))){
                    $arr=array();
                    $i=0;
                    $uget=User_get::where('phone','like','%'.$request->input('phone').'%')->get();
                    foreach ($uget as $item){
                        $arr[$i]=$item->id;
                        $i++;
                    }
                    $rent=Rental::with('user_get','sale')->whereIN('user_get_id',$uget)->orderBy('created_at','desc')->get();
                    //$rent=Rental::all()->user_get()->where('phone','like','%'.$request->input('phone').'%')->orderBy('created_at','desc')->get();
                    $this->form=view('form.reportshow',[
                        'rentalbikes'=>$rent,
                        'phone'=>$request->input('phone'),
                    ]);
                    $this->vars=array_add($this->vars,'form',$this->form);
                    $this->title="REPORT RENTAL BIKES SEARCH";
                    return $this->renderOutput();
                }else{
                    return redirect(route('show_report'))->withErrors(['errors'=>'Please insert correct phone number'])->withInput();
                }
            }elseif (empty($request->input('phone'))&&!empty($request->input('date'))){
                $this->validate($request,['date'=>'required|date' ]);
                $rent=Rental::with('user_get','sale')->whereDate('created_at','=',$request->input('date'))->orderBy('created_at','desc')->get();
                $this->form=view('form.reportshow',['rentalbikes'=>$rent,'date'=>$request->input('date')]);
                $this->vars=array_add($this->vars,'form',$this->form);
                $this->title="REPORT RENTAL BIKES SHOW";
                return $this->renderOutput();
            }elseif (empty($request->input('phone'))&&empty($request->input('date'))){
                return redirect(route('show_report'))->withErrors(['errors'=>'Please insert correct phone number or date'])->withInput();
            }
        }else return redirect(route('show_rentalbike'));
    }
    public function agentsshow(){
        if(Auth::user()->roles()->first()->name=='admin'){
            session()->put('datetime',date("Y-m-d H:i:s"));
            $agent= Agent::all();
            $this->form=view('form.reportagentshow',['agents'=>$agent]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="REPORT AGENT SHOW";
            return $this->renderOutput();
        }else return redirect(route('show_rentalbike'));

    }
    public function pagent(){
        if(Auth::user()->roles()->first()->name=='admin'){
            if(isset($_POST['id']))session()->put('agentsshow_report',$_POST['id']);
            $agent= Agent::where('id',session('agentsshow_report'))->first();
            $b=0;
            if($agent){
                if(isset($_POST['t'])){
                    $rent=Rental::with('user_get','sale')->where('status',2)->where('agent_id',$agent->id)->orderBy('created_at','desc')->get();
                    $b=1;
                }elseif(isset($_POST['p'])){
                    $rent=Rental::with('user_get','sale')->where('status',10)->where('agent_id',$agent->id)->orderBy('created_at','desc')->take(20)->get();
                    $b=2;
                }elseif(isset($_POST['search'])){
                    $rent=Rental::with('user_get','sale')->where('agent_id',$agent->id)->orderBy('created_at','desc')->take(20)->get();
                    $b=3;
                }
                $this->form=view('form.reportpagent',[
                    'rentalbikes'=>$rent,
                    'agent'=>$agent,
                    'bool'=>$b,
                ]);
                $this->vars=array_add($this->vars,'form',$this->form);
                $this->title="REPORT AGENT paid";
                return $this->renderOutput();
            }else return redirect(route('show_rentalbike'));
        }else return redirect(route('show_rentalbike'));

    }
    public function savepaid(){
        if(Auth::user()->roles()->first()->name=='admin'){
            if(session('postreq')==session('datetime')){
                return redirect()->route('agentsshow_report');
            }else {
                session()->put('postreq',session('datetime'));
            }
            if(!empty(session('agentsshow_report'))&&!empty($_POST['checkpaid'])){
                $check = $_POST['checkpaid'];
                if(!empty($check)){
                    Rental::where('agent_id',session('agentsshow_report'))->whereIN('id',$check)->update(['status'=>'10']);
                }
            }
            return redirect()->route('agentsshow_report');
        }else return redirect(route('show_rentalbike'));
    }
    public function paidsearch(Request $request){
        if(Auth::user()->roles()->first()->name=='admin'){
            $agent= Agent::where('id',session('agentsshow_report'));
            $b=0;
            if($agent) {
                $agent = $agent->first();
                $this->validate($request, [
                    'date' => 'required|date',
                    'date2' => 'nullable|date',
                ]);
                if (!empty($request->input('date')) && empty($request->input('date2'))&&empty($request->input('take'))) {
                    $rent = Rental::with('user_get', 'sale')->where('agent_id', session('agentsshow_report'))->where('created_at','>=',$request->input('date'))->where('created_at','<',date('Y-m-d H:i:s',strtotime($request->input('date'))+24*3600))->orderBy('created_at', 'desc')->get();
                    $b = 3;
                }elseif (!empty($request->input('date')) && !empty($request->input('date2'))&&empty($request->input('take'))) {
                    $rent = Rental::with('user_get', 'sale')->where('agent_id', session('agentsshow_report'))->where('created_at','<=',$request->input('date2'))->where('created_at','>=',$request->input('date'))->orderBy('created_at', 'desc')->get();
                    $b = 3;
                }
                $this->form = view('form.reportpagent', [
                    'rentalbikes' => $rent,
                    'agent' => $agent,
                    'date'=>$request->input('date'),
                    'date2'=>$request->input('date2'),
                    'bool' => $b,
                ]);
                $this->vars = array_add($this->vars, 'form', $this->form);
                $this->title = "REPORT AGENT paid";
                return $this->renderOutput();
            }else return redirect(route('show_rentalbike'));
        }else return redirect(route('show_rentalbike'));
    }
    public function ruser(){
        if(Auth::user()->roles()->first()->name=='admin'){
            if(isset($_POST['id']))session()->put('usersshow_report',$_POST['id']);
            $user= User::where('id',session('usersshow_report'))->first();
            $b=0;
            if($user){
                if(isset($_POST['t'])){
                    $rent=Rental::with('user_get','sale')->where('status',0)->where('user_id',$user->id)->orderBy('created_at','desc')->get();
                    $b=1;
                }elseif(isset($_POST['p'])){
                    $rent=Rental::with('user_get','sale')->where('status','!=',0)->where('user_id',$user->id)->orderBy('created_at','desc')->take(20)->get();
                    $b=2;
                }elseif(isset($_POST['search'])){
                    $rent=Rental::with('user_get','sale')->where('user_id',$user->id)->orderBy('created_at','desc')->take(20)->get();
                    $b=3;
                }elseif(isset($_POST['c'])){
                    return redirect()->route('changerent_report');
                }
                $this->form=view('form.reportuser',[
                    'rentalbikes'=>$rent,
                    'user'=>$user,
                    'bool'=>$b,
                ]);
                $this->vars=array_add($this->vars,'form',$this->form);
                $this->title="REPORT AGENT paid";
                return $this->renderOutput();
            }else return redirect(route('show_rentalbike'));
        }else return redirect(route('show_rentalbike'));

    }
    public function usersearch(Request $request){
        if(Auth::user()->roles()->first()->name=='admin'){
            $user= User::where('id',session('usersshow_report'))->first();
            $b=0;
            if($user) {
                $this->validate($request, [
                    'date' => 'required|date',
                    'date2' => 'nullable|date',
                ]);
                if (!empty($request->input('date')) && empty($request->input('date2'))&&empty($request->input('take'))) {
                    $rent = Rental::with('user_get', 'sale')->where('user_id',$user->id)->where('created_at','<',date('Y-m-d H:i:s',strtotime($request->input('date'))+24*3600))->where('created_at','>=',$request->input('date'))->orderBy('created_at', 'desc')->get();
                    $b = 3;
                }elseif (!empty($request->input('date')) && !empty($request->input('date2'))&&empty($request->input('take'))) {
                    $rent = Rental::with('user_get', 'sale')->where('user_id',$user->id)->where('created_at','<=',$request->input('date2'))->where('created_at','>=',$request->input('date'))->orderBy('created_at', 'desc')->get();
                    $b = 3;
                }
                $this->form = view('form.reportuser', [
                    'rentalbikes' => $rent,
                    'user' => $user,
                    'date'=>$request->input('date'),
                    'date2'=>$request->input('date2'),
                    'bool' => $b,
                ]);
                $this->vars = array_add($this->vars, 'form', $this->form);
                $this->title = "REPORT AGENT paid";
                return $this->renderOutput();
            }
        }else     return redirect(route('show_rentalbike'));

    }
    public function usershow(){
        if(Auth::user()->roles()->first()->name=='admin'){
            session()->put('datetime',date("Y-m-d H:i:s"));
            $users= User::all();
            $utotal=array();
            $datestart=date("Y-m-d",strtotime( "-".date('d',strtotime(now()))." day" ));
            foreach ($users as $user) {
                $utotal[$user->id]=DB::select('SELECT SUM(sales.total) as sum FROM sales,rentals WHERE sales.deleted_at is NULL and sales.rental_id=rentals.id AND rentals.created_at>? AND rentals.user_id=?',[
                    $datestart,
                    $user->id
                    ]);
                $utotal[$user->id]=$utotal[$user->id][0]->sum;
            }
            $this->form=view('form.reportusershow',[
                'users'=>$users,
                'datestart'=>$datestart,
                'utotal'=>$utotal,
            ]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="REPORT USERS SHOW";
            return $this->renderOutput();
        }else return redirect(route('show_rentalbike'));
    }
    public function changerent($datestart =false ,$dateend=false){
        if(!$datestart&&!$dateend){
            $datestart=date("Y-m-d", strtotime("-" . date('d', strtotime(now())) . " day"));
            $dateend=now();
        }elseif(!$datestart&&$dateend){
            $datestart=date("Y-m-d", strtotime("-" . date('d', strtotime($dateend)) . " day"));
        }elseif($datestart&&!$dateend){
            $dateend=now();
        }
        if(Auth::user()->roles()->first()->name=='admin'){
            $user= User::where('id',session('usersshow_report'))->first();
            //dd($user);
            if(!empty($user)) {
                $b = 0;
                $arr = array();
                $sale_arr = array();
                $accessories_arr = array();
                $k = 0;
               /// $rent = Rental::where('user_id',$user->id)->where('created_at', '<', now())->where('created_at', '>=', $datestart)->get();
                $trashed = Sale::onlyTrashed()->where('delete_user_id',$user->id)->where('created_at', '>=', $datestart)->where('created_at', '<', $dateend)->get();
               // dd($trashed);
                if(!empty($trashed)) {
                    foreach ($trashed as $item) {
                        $sale_arr[$item->rental_id][$item->id]['paymant_method'] =$item->paymant_method;
                        $sale_arr[$item->rental_id][$item->id]['deposit'] =$item->deposit;
                        $sale_arr[$item->rental_id][$item->id]['total'] =$item->total;
                        $sale_arr[$item->rental_id][$item->id]['totalmath'] =$item->totalmath;
                        $sale_arr[$item->rental_id][$item->id]['insurance'] =$item->insurance;
                        $sale_arr[$item->rental_id][$item->id]['dis'] =$item->dis;
                        $sale_arr[$item->rental_id][$item->id]['tax'] =$item->tax;
                        $sale_arr[$item->rental_id][$item->id]['deleted_at'] =$item->deleted_at;
                        $sale_arr[$item->rental_id][$item->id]['created_at'] =$item->created_at;

                        $arr[$k] = $item->rental_id;
                        $k++;
                    }
                }
                $trashed=Accessories::onlyTrashed()->where('delete_user_id',$user->id)->where('created_at', '>=', $datestart)->where('created_at', '<', $dateend)->get();
                if(!empty($trashed)) {
                    foreach ($trashed as $item) {
                        $accessories_arr[$item->rental_id][$item->id]['lock']=$item->lock;
                        $accessories_arr[$item->rental_id][$item->id]['helmet']=$item->helmet;
                        $accessories_arr[$item->rental_id][$item->id]['basket']=$item->basket;
                        $accessories_arr[$item->rental_id][$item->id]['deleted_at']=$item->deleted_at;

                        $arr[$k] = $item->rental_id;
                        $k++;
                    }
                }
                if(!empty($arr)) {
                    $rent = Rental::with('sale','acsor','user_get','rental_bike')->whereIN('id', $arr)->get();
                    //dd($rent);
                   // dd($rent);
                    if(!empty($rent)) {
                        $this->form = view('form.reportchanged', [
                            'rentalbikes'=>$rent,
                            'sales'=>$sale_arr,
                            'accessories'=>$accessories_arr,
                            'datestart'=>$datestart,
                        ]);
                        $this->vars = array_add($this->vars, 'form', $this->form);
                        $this->title = "REPORT USERS CHAGED";
                        return $this->renderOutput();
                    }
                }
            }
            $datestart=$datestart.' Not changed';
            $this->form = view('form.reportchanged', [
                'datestart'=>$datestart,
            ]);
            $this->vars = array_add($this->vars, 'form', $this->form);
            $this->title = "REPORT USERS CHAGED";
            return $this->renderOutput();
        }else   return redirect(route('show_rentalbike'));
    }
    public function searchchangerent(Request $request){
        if(Auth::user()->roles()->first()->name=='admin'){
            $user= User::where('id',session('usersshow_report'))->first();
            $b=0;
            if($user) {
                $this->validate($request, [
                    'date' => 'required|date',
                    'date2' => 'nullable|date|after:date',
                ]);
                return $this->changerent($request->input('date'),$request->input('date2'));
            }
        }
        return redirect(route('show_rentalbike'));
    }
    //
}
