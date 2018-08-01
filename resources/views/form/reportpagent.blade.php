@if($bool==3)
    <form  class="form-group" action="{{route('paidsearch_report')}}" method="post">
        {{ csrf_field() }}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-1 form-group" style="text-align: right">

            </div>
            <div class="col-lg-3 form-group" >
                <input class="form-control " type="text" id="date" name="date"  @if(isset($date)) value="{{$date}}" @endif/>
            </div>
            <div class="col-lg-3 form-group" >
                <input class="form-control " type="text" id="date2" name="date2"  @if(isset($date2)) value="{{$date2}}" @endif/>
            </div>
            <div class="col-lg-3 form-group" >
                <input type="submit" name="search" class="btn btn-primary" value="SEARCH"/>
            </div>
        </div>
    </form>
@endif
<form  class="form-group" action="{{route('savepaid_report')}}" method="post">
    {{ csrf_field() }}
    @set($i,0)
    @set($sum,0)
    @set($d,0)
    @set($n,0)
    <div class="table-responsive">
       AGENT: {{ $agent->name }}
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>User_get</th>
                <th>User_get_phone</th>
                <th>Total</th>
                <th>w_dis&nbsp{{ $agent->profit_with_insurance }}%</th>
                <th>wout_dis&nbsp{{ $agent->profit_without_insurance }}%</th>
                <th>Rent date time</th>
                <th >Paid</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($rentalbikes))
                @foreach($rentalbikes as $rentalbike)
                    <tr><td>{{$rentalbike->id}}</td>
                        <td>{{$rentalbike->user_get->name}}</td>
                        <td>{{$rentalbike->user_get->phone}}</td>
                        <td>{{$rentalbike->sale->total}}</td>
                        <td>@if($rentalbike->sale->insurance!=0)
                            @if($rentalbike->status==2)  @set($n,$n+($rentalbike->sale->total*$agent->profit_with_insurance/100))
                            @elseif ($rentalbike->status==10) @set($i,$i+($rentalbike->sale->total*$agent->profit_with_insurance/100))@endif
                                @set($d,$rentalbike->sale->total*$agent->profit_with_insurance/100)
                                {{ $d }}
                            @else
                                0
                            @endif
                        </td>
                        <td>@if($rentalbike->sale->insurance==0)
                                @if($rentalbike->status==2)  @set($n,$n+($rentalbike->sale->total*$agent->profit_without_insurance/100))
                                @elseif ($rentalbike->status==10) @set($i,$i+($rentalbike->sale->total*$agent->profit_without_insurance/100))@endif
                                @set($d,$rentalbike->sale->total*$agent->profit_without_insurance/100)
                                {{ $d }}
                            @else
                                0
                            @endif
                        </td>

                        <td>{{$rentalbike->created_at}}</td><td>
                            @if($rentalbike->status==2)<input type="checkbox" name="checkpaid[]" value="{{ $rentalbike->id }}" checked>
                            @elseif($rentalbike->status==0)NOT RETURNED
                            @elseif($rentalbike->status==10)PAID @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="form-group float-lg-right">
<pre>@if($i>0)TOTAL PAID  {{ $i }}<br/>@endif
@if($n>0)TOTAL NOT PAID  {{ $n }}<br/>@endif
</pre>
        </div>
        <span id="check_login_all">
            @if($bool==1||$bool=4)<input type="submit" class="btn btn-lg btn-success btn-block" name="save" value="SAVE"/>@endif
        </span>
    </div>
</form>