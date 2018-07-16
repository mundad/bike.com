<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
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

class RentalController extends HomeController
{
    public function __construct() {
        parent::__construct();
        $this->template ='rentalbike';
        session()->put('postreq','');
    }
    public function show(){
        $rent=Rental::with('user_get','sale')->where('status',0)->orderBy('created_at','desc')->take(20)->get();
        $this->form=view('form.rentalbikeshow',['rentalbikes'=>$rent]);
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="RENTAL BIKES SHOW";
        return $this->renderOutput();
    }
    public function search(Request $request){
        //dd(1);
        if(!empty($request->input('phone'))&&empty($request->input('date'))){
            if(is_numeric($request->input('phone'))){
                $arr=array();
                $i=0;
                $uget=User_get::where('phone','like','%'.$request->input('phone').'%')->get();
                foreach ($uget as $item){

                    $arr[$i]=$item->id;
                    $i++;
                }
                $rent=Rental::with('user_get','sale')->where('status',0)->whereIN('user_get_id',$uget)->orderBy('created_at','desc')->get();
                //$rent=Rental::all()->user_get()->where('phone','like','%'.$request->input('phone').'%')->orderBy('created_at','desc')->get();
                $this->form=view('form.rentalbikeshow',[
                    'rentalbikes'=>$rent,
                    'phone'=>$request->input('phone'),
                ]);
                $this->vars=array_add($this->vars,'form',$this->form);
                $this->title="RENTAL BIKES SEARCH";
                return $this->renderOutput();
            }else{
                return redirect(route('show_rentalbike'))->withErrors(['errors'=>'Please insert correct phone number'])->withInput();
            }
        }elseif (empty($request->input('phone'))&&!empty($request->input('date'))){
            $this->validate($request,['date'=>'required|date' ]);
            $rent=Rental::with('user_get','sale')->where('status',0)->whereDate('created_at','=',$request->input('date'))->orderBy('created_at','desc')->get();
            $this->form=view('form.rentalbikeshow',['rentalbikes'=>$rent,'date'=>$request->input('date')]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="RENTAL BIKES SHOW";
            return $this->renderOutput();
        }elseif (empty($request->input('phone'))&&empty($request->input('date'))){
            return redirect(route('show_rentalbike'))->withErrors(['errors'=>'Please insert correct phone number or date'])->withInput();
        }
    }
    public function addform(){
        session()->put('datetime',date("Y-m-d H:i:s"));
        if(!empty(session('change_id'))) { session()->put('change_id',date("")); }
       //   dd(session('datetime'));
        $this->form=view('form.rentalbikeadd',[
                                'agents'=>Agent::all('name'),
                                'biketypes'=>Biketype::all("name","id"),
                                'datetime'=>session('datetime'),
                                'tax'=>env('TAX'),
                            ]);
        $this->vars=array_add($this->vars,'form',$this->form);
        $this->title="RENTAL BIKES ADD";

        return $this->renderOutput();
    }
    public function in(){
        if(isset($_POST['id'])){
            try{
                Rental::where('id',$_POST['id'])->update([
                    'user_id_in'=>Auth::user()->first()->id,
                    'date_in'=>date('Y-m-d H:i:s'),
                    'status'=>2
                ]);
                return redirect(route('show_rentalbike'));
            }catch (\PDOException $e){

            }
        }
        return redirect(route('show_rentalbike'))->withErrors(['errors'=>'Not correct'])->withInput();
    }
    public function save(Request $request){
        if(session('postreq')==session('datetime')){
            return redirect()->route('print_rentalbike');
        }else {
            session()->put('postreq',session('datetime'));
        }
        $rules=['name' => 'max:50|nullable',
            'phone' => 'required|digits_between:7,19',//|unique:user_gets,phone',
            'second_name' => 'max:50|nullable',
            'address' => 'max:250|nullable',
            'email' => 'max:250|email|nullable', ///|unique:user_gets,email',
            'deposit' => 'required',
            'helmet'=>'integer|nullable',
            'lock'=>'integer|nullable',
            'pay'=>'integer|in:1,2',
            'baby_seat'=>'integer|nullable',
            'basket'=>'integer|nullable',
            'total'=>'required|numeric',
            'sub_total'=>'numeric',
            'insurance'=>'numeric|nullable|min:0',
            'hrs'=>'numeric|nullable|min:0',
            'time_out'=>'date|nullable',
            'time_in'=>'date|nullable|after:time_out',
            'dis'=>'numeric|nullable|min:0',
            'agent'=>'required|max:255|exists:agents,name',
            'tax'=>'numeric',];
        $biketypes=Biketype::all();
        $qtr=array();
        $hrs=0;
        $sdate=session('datetime');
        $totalmath=0;
        $ph=array();
        $pd=array();
        $arr=array();
        $k=0;
        $ik=0;
        $date1=0;
        $date2=0;
        foreach ($biketypes as $biketype) {
            $ph=array_add($ph,$biketype->id,$biketype->price_h);
            //dd($biketype);
            $pd=array_add($pd,$biketype->id,$biketype->price_d);
           // dump( 'qty_' . $biketype->id);
            if($request->has('qty_' . $biketype->id)&& is_numeric($request->input('qty_' . $biketype->id))&&$request->input('qty_' . $biketype->id) > 0){
                $qtr=array_add($qtr, $ik,$biketype->id);
                $ik++;
            }
        }
        //dd(1);
        if(empty($qtr)&&(!empty($request->input('hrs'))||!empty($request->input('time_out'))||!empty($request->input('time_in')))){
            $arr=array_add($arr,'errors','Please insert count of bike you insert any');
            $k++;
        }
        if($k!=0){
            return redirect(route('addform_rentalbike'))->withErrors($arr)->withInput();
        }
        if(empty($qtr)){
            $arr=array_add($arr,'errors','Please insert count of bike');
            $k++;
        }else{
            if($request->has('hrs')&&empty($request->input('time_out'))&&empty($request->input('time_in'))&&is_numeric($request->input('hrs'))&&$request->input('hrs')>0&&$request->input('hrs')<24){
                $hrs=$request->input('hrs');
            }elseif(empty($request->input('hrs'))&&$request->has('time_out')&&$request->has('time_in')){
                $sdate=strtotime($request->input('time_out'))-strtotime(date('Y-m-d',strtotime($sdate)));
                //dd($sdate);
                if($sdate<0){
                    $arr=array_add($arr,'errors','Please insert correct time out');
                    $k++;
                }
            }else{
                if(empty($request->input('hrs'))&&empty($request->input('time_ou'))){
                    $arr = array_add($arr, 'errors', 'Please insert time out,time in or hours');
                    $k++;
                }else{
                    $arr = array_add($arr, 'errors', 'Please insert hours between 1-23 or time out,time in');
                    $k++;
                }
            }
        }
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return redirect(route('addform_rentalbike'))
                ->withErrors($validator)
                ->withInput();
        }
        if($k!=0){
            return redirect(route('addform_rentalbike'))->withErrors($arr)->withInput();
        }
        //dd($qtr);
        try {
            if(empty(session('change_id'))) {
                DB::beginTransaction();
                $unotenter=array();
                empty($request->input('name'))?array_add($unotenter,'name','not enter'):array_add($unotenter,'name',$request->input('name'));
                empty($request->input('second_name'))?array_add($unotenter,'second_name','not enter'):array_add($unotenter,'second_name',$request->input('second_name'));
                empty($request->input('address'))?array_add($unotenter,'address','not enter'):array_add($unotenter,'address',$request->input('address'));
                empty($request->input('email'))?array_add($unotenter,'email','not enter'):array_add($unotenter,'email',$request->input('email'));
                $ugetid = User_get::firstOrCreate([
                    'phone' => $request->input('phone')],$unotenter);
                $agid = new Agent();
                $agid = $agid->select('id')->where('name', $request->input('agent'))->first();
                //dd($agid);

                $rentid = Rental::create([
                    'agent_id' => $agid->id,
                    'user_get_id' => $ugetid->id,
                    'user_id' => Auth::user()->first()->id,
                ]);
                session()->put('print_id', $rentid->id);
                if(!empty( $request->input('lock'))||!empty( $request->input('helmet') )||!empty( $request->input('basket') )||!empty( $request->input('baby_seat') )){
                    Accessories::create([
                        'rental_id' => $rentid->id,
                        'lock' => $request->input('lock')?$request->input('lock'):0 ,
                        'helmet' => $request->input('helmet')?$request->input('helmet'):0 ,
                        'basket' => $request->input('basket')?$request->input('basket'):0  ,
                        'baby_seat' => $request->input('baby_seat')?$request->input('baby_seat'):0 ,
                    ]);
                }
                //dd($ph);
                for ($i = 0; $i < $ik; $i++) {
                    if (!empty($hrs[$i])) {
                        //dd(1);
                        Rental_bike::create([
                            'rental_id' => $rentid->id,
                            'bike_type_id' => $qtr[$i],
                            'count' => $request->input('qty_' . $qtr[$i]),
                        ]);
                        $totalmath=$totalmath+$ph[$qtr[$i]]*$request->input('qty_' . $qtr[$i])*$hrs;
                    } else {
                        // dd(2);
                        Rental_bike::create([
                            'rental_id' => $rentid->id,
                            'bike_type_id' => $qtr[$i],
                            'count' => $request->input('qty_' . $qtr[$i]),
                        ]);
                        $totalmath=$totalmath+$pd[$qtr[$i]]*$request->input('qty_' . $qtr[$i])*(strtotime($request->input('time_in'))-strtotime($request->input('time_out')))/3600/24;
                    }
                }
                if($hrs!=0){
                    $date1= date('Y-m-d H:i:s');
                    $date2= date('Y-m-d H:i:s', strtotime($hrs . ' hour'));
                }else{
                    $date1=$request->input('time_out');
                    $date2=$request->input('time_in');
                }


                Sale::create([
                    'rental_id' => $rentid->id,
                    'paymant_method' => $request->input('pay'),
                    'totalmath' =>$totalmath,
                    'date_time_in' => $date2,
                    'date_time_out' => $date1,
                    'total' => $request->input('total'),
                    'tax' => $request->input('tax'),
                    'deposit' => $request->input('deposit'),
                    'insurance' => $request->input('insurance'),
                    'dis' => $request->input('dis'),
                ]);
                DB::commit();
            }else {

                /////change data ///
                ///\\\\\\\\\\\\///////
                DB::beginTransaction();
                $upd = array();
                $updsale = array();
                $creac = array();
                $arrrentbikeid = array();
                $userid = Auth::user()->id;
                $rent = Rental::all()->where('id', session('change_id'))->first();
                if ($rent) {
                    session()->put('print_id', $rent->id);
                    $uget = User_get::all()->where('phone', $request->input('phone'))->first();
                    if ($uget->name != $request->input('name')) $upd = array_add($upd, 'name', $request->input('name'));
                    if ($uget->second_name != $request->input('second_name')) $upd = array_add($upd, 'second_name', $request->input('second_name'));
                    if ($uget->address != $request->input('address')) $upd = array_add($upd, 'address', $request->input('address'));
                    if ($uget->email != $request->input('email')) $upd = array_add($upd, 'email', $request->input('email'));
                    if (!empty($upd)) User_get::where('phone', $request->input('phone'))->update($upd);

                    $agid = new Agent();
                    $agid = $agid->select('id')->where('name', $request->input('agent'))->first();

                    if ($rent->agent_id != $agid->id) Rental::where('id', session('change_id'))->update(['agent_id' => $agid->id]);

                    $accessories = Accessories::all()->where('rental_id', $rent->id)->first();
                    if ($accessories) {
                        if ($accessories->lock != $request->input('lock') || $accessories->helmet != $request->input('helmet') || $accessories->basket != $request->input('basket') || $accessories->baby_seat != $request->input('baby_seat')) {
                            if (!empty($request->input('lock')) || !empty($request->input('helmet')) || !empty($request->input('basket')) || !empty($request->input('baby_seat'))) {
                                $creac = array_add($creac, 'lock', !empty($request->input('lock')) ? $request->input('lock') : 0);
                                $creac = array_add($creac, 'helmet', !empty($request->input('helmet')) ? $request->input('helmet') : 0);
                                $creac = array_add($creac, 'basket', !empty($request->input('basket')) ? $request->input('basket') : 0);
                                $creac = array_add($creac, 'baby_seat', !empty($request->input('baby_seat')) ? $request->input('baby_seat') : 0);
                            }
                            Accessories::where('rental_id', $rent->id)->update(['delete_user_id' => $userid]);
                            Accessories::where('rental_id', $rent->id)->delete();
                        }

                    } elseif (empty($accessories)) {
                        if (!empty($request->input('lock')) || !empty($request->input('helmet')) || !empty($request->input('basket')) || !empty($request->input('baby_seat'))) {
                            $creac = array_add($creac, 'lock', !empty($request->input('lock')) ? $request->input('lock') : 0);
                            $creac = array_add($creac, 'helmet', !empty($request->input('helmet')) ? $request->input('helmet') : 0);
                            $creac = array_add($creac, 'basket', !empty($request->input('basket')) ? $request->input('basket') : 0);
                            $creac = array_add($creac, 'baby_seat', !empty($request->input('baby_seat')) ? $request->input('baby_seat') : 0);
                        }
                    }
                    //dd($creac);
                    if (!empty($creac)) {
                        $creac = array_add($creac, 'rental_id', $rent->id);
                        Accessories::create($creac);
                    }
                    //dd($rentbike);

                    $rentbikes = Rental_bike::all()->where('rental_id', $rent->id);

                    foreach ($biketypes as $biketype) {
                        foreach ($rentbikes as $rentbike) {
                            if ($biketype->id == $rentbike->bike_type_id) {
                                if ($rentbike->count != $request->input('qty_' . $biketype->id)) {
                                    Rental_bike::where('id', $rentbike->id)->update(['delete_user_id' => $userid]);
                                    Rental_bike::where('id', $rentbike->id)->delete();
                                    Rental_bike::create([
                                        'rental_id' => $rent->id,
                                        'bike_type_id' => $biketype->id,
                                        'count' => $request->input('qty_' . $biketype->id),
                                    ]);
                                }
                            }
                        }
                    }
                    $date1 = 0;
                    $date2 = 0;
                    if ($hrs != 0) {
                        $date1 = date('Y-m-d H:i:s');
                        $date2 = date('Y-m-d H:i:s', strtotime($hrs . ' hour'));
                    } else {
                        $date1 = $request->input('time_out');
                        $date2 = $request->input('time_in');
                    }

                    $sl = Sale::where('rental_id', $rent->id)->first();

                    $hch = (strtotime($sl->date_time_in) - strtotime($sl->date_time_out)) / 3600;
                    if ($totalmath == 0) $totalmath = $sl->totalmath;
                    if ((strtotime($sl->date_time_out) != strtotime($request->input('time_out')) && !empty($request->input('time_out'))) || (strtotime($sl->date_time_in) != strtotime($request->input('time_in')) && !empty($request->input('time_in'))) || ($hch < 24 && $hch != $request->input('hrs')) || $sl->insurance != $request->input('insurance') || $sl->dis != $request->input('dis') || $sl->total != $request->input('total') || $sl->paymant_method != $request->input('pay') || $sl->tax != $request->input('tax') || $sl->deposit != $request->input('deposit') || $sl->totalmath != $totalmath) {
                        Sale::where('id', $sl->id)->update(['delete_user_id' => $userid]);
                        Sale::where('id', $sl->id)->delete();
                        Sale::create([
                            'rental_id' => $rent->id,
                            'paymant_method' => $request->input('pay'),
                            'totalmath' => $totalmath,
                            'total' => $request->input('total'),
                            'date_time_in' => $date2,
                            'date_time_out' => $date1,
                            'tax' => $request->input('tax'),
                            'deposit' => $request->input('deposit'),
                            'insurance' => $request->input('insurance'),
                            'dis' => $request->input('dis'),
                        ]);
                    }
                    session()->put('change_id', '');
                    DB::commit();
                }
            }
            return redirect()->route('print_rentalbike');
        } catch (\PDOException $e) {
            return redirect(route('addform_rentalbike'))->withErrors(['errors'=>'ERROR DATA BASE '.$e])->withInput();
            DB::rollBack();
        }

    }

    public function change(){
        $rent=false;
        if(isset($_POST['id'])) {
            session()->put('change_id',$_POST['id']);
            session()->put('datetime',date("Y-m-d H:i:s"));
        }
            $rent=Rental::all()->where('id','=',session('change_id'))->first();
        //dd( $rent_bikes);
        if($rent) {
            $rent->load('user_get','sale');
            $rent_bikes = Rental_bike::all()->where('rental_id', $rent->id);
            $biketypes = Biketype::all('id', 'name');
            $agname = new Agent();
            $agname = $agname->select('name')->where('id', $rent->agent_id)->first();
            session()->put('old.agent', $agname->name);
            session()->put('old.name', $rent->user_get->name);
            session()->put('old.phone', $rent->user_get->phone);
            session()->put('old.second_name', $rent->user_get->second_name);
            session()->put('old.address', $rent->user_get->address);
            session()->put('old.email', $rent->user_get->email);

            session()->put('old.pay', $rent->sale->paymant_method);
            session()->put('old.deposit', $rent->sale->deposit);
            session()->put('old.dis', $rent->sale->dis);
            session()->put('old.insurance', $rent->sale->insurance);
            session()->put('old.tax', $rent->sale->tax);
            session()->put('old.sub_total', $rent->sale->totalmath);
            session()->put('old.total', $rent->sale->total);
            $accessories = Accessories::all()->where('rental_id', $rent->id)->first();
            if ($accessories) {
                session()->put('old.lock', $accessories->lock);
                session()->put('old.helmet', $accessories->helmet);
                session()->put('old.basket', $accessories->basket);
                session()->put('old.baby_seat', $accessories->baby_seat);
            }else{
                session()->put('old.lock', NULL);
                session()->put('old.helmet', NULL);
                session()->put('old.basket', NULL);
                session()->put('old.baby_seat', NULL);
            }
            foreach ($biketypes as $biketype) {
                session()->put('old.qty_'.$biketype->id, NULL);
            }
            foreach ($rent_bikes as $item) {
                session()->put('old.qty_' . $item->bike_type_id, $item->count);
            }
            $r=(strtotime($rent->sale->date_time_in)-strtotime($rent->sale->date_time_out))/3600;
            if($r<24){
                session()->put('old.hrs', $r);
            }else {
                session()->put('old.time_in', date('Y-m-d',strtotime($rent->sale->date_time_in)));
                session()->put('old.time_out', date('Y-m-d',strtotime($rent->sale->date_time_out)));
            }
            $this->form=view('form.rentalbikechange',[
                'agents'=>Agent::all('name'),
                'biketypes'=>$biketypes,
                'datetime'=>session('datetime'),
                'tax'=>env('TAX'),
            ]);
            $this->vars=array_add($this->vars,'form',$this->form);
            $this->title="RENTAL BIKES CHANG";

            //dd(session('old'));
            return $this->renderOutput();
        }else return redirect(route('home'));
    }
    public function print(){
        if(isset($_POST['id']))
            session()->put('print_id',$_POST['id']);
        if(!empty(session('print_id'))){
            $rent=Rental::where('id',session('print_id'))->first();
            if($rent){
               $rent->load('user_get','sale');
               $accessories=Accessories::where('rental_id',$rent->id)->first();
               if(!$accessories)$accessories='';
                $this->menu=view('layouts.menu');
               $this->form=view('form.printform',[
                    'agent'=>Agent::where('id',$rent->agent_id)->first(),
                    'biketypes'=>Biketype::all("name","id"),
                    'rental'=>$rent,
                    'tax'=>env('tax'),
                    'accessories'=>$accessories,
                    'rental_bikes'=>Rental_bike::all()->where('rental_id',$rent->id),
                ]);
                $this->vars=array_add($this->vars,'form',$this->form);
                $this->title="PRINT";
                session()->put('print_id','');
                return $this->renderOutput();
            }else return redirect(route('home'));
        }else return redirect(route('home'));
    }
    //
}
