@if($bool==3)
    <form  class="form-group" action="{{route('urentsearch_report')}}" method="post">
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
                <input class="form-control " type="date" name="date"  @if(isset($date)) value="{{$date}}" @endif/>
            </div>
            <div class="col-lg-3 form-group" >
                <input class="form-control " type="date" name="date2"  @if(isset($date2)) value="{{$date2}}" @endif/>
            </div>
            <div class="col-lg-3 form-group" >
                <input type="submit" name="search" class="btn btn-primary" value="SEARCH"/>
            </div>
        </div>
    </form>
@endif
    @set($i,0)
    @set($n,0)
    @set($s,0)
    <div class="table-responsive">
        USER: {{ $user->name }}
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>User_get</th>
                <th>User_get_phone</th>
                <th>Total</th>
                <th>Rent date time</th>
                <th>IN</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($rentalbikes))
                @foreach($rentalbikes as $rentalbike)
                    <tr><td>{{$rentalbike->id}}</td>
                        <td>{{$rentalbike->user_get->name}}</td>
                        <td>{{$rentalbike->user_get->phone}}</td>
                        <td>{{$rentalbike->sale->total}}</td>
                            @set($s,$s+$rentalbike->sale->total)
                            @if($rentalbike->status==2||$rentalbike->status==10)  @set($n,$n+$rentalbike->sale->total)
                            @elseif ($rentalbike->status==0) @set($i,$i+$rentalbike->sale->total) @endif

                        <td>{{$rentalbike->created_at}}</td>
                        <td>
                            @if($rentalbike->status==2||$rentalbike->status==10)RETURNED
                            @elseif($rentalbike->status==0)NOT RETURNED @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <div class="form-group float-lg-right">
<pre>TOTAL: {{ $s }}
TOTAL RETURNED: {{ $n }}
TOTAL NOT RETURNED: {{ $i }}
</pre>
        </div>
    </div>