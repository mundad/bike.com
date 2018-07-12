

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form  class="form-group" action="{{route('search_rentalbike')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-3 form-group" >
             <input class="form-control" type="text" name="phone" placeholder="PHONE" @if(isset($phone)) value="{{$phone}}" @endif>
        </div>
        <div class="col-lg-3 form-group" >
            <input class="form-control " type="date" name="date" @if(isset($date)) value="{{$date}}" @endif>
        </div>
        <div class="col-lg-3 form-group" >
            <input type="submit" name="search" class="btn btn-primary" value="SEARCH">
        </div>
    </div>
</form>
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>User_get</th>
            <th>User_get_phone</th>
            <th>Total</th>
            <th>Sub-Total</th>
            <th>Created_date</th>
            <th >Change-Print-in</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($rentalbikes))
        @foreach($rentalbikes as $rentalbike)
            <tr><td>{{$rentalbike->id}}</td>
                <td>{{$rentalbike->user_get->name}}</td>
                <td>{{$rentalbike->user_get->phone}}</td>
                <td>{{$rentalbike->sale->total}}</td>
                <td>{{$rentalbike->sale->totalmath}}</td>
                <td>{{$rentalbike->created_at}}</td>
                <td><form method="post" action="{{route('change_rentalbike')}}" name="form" style="float: left;margin-right:5px">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-warning" value="CHANGE" name="t" />
                        <input type="hidden" width="1px" name="id"  value="{{$rentalbike->id}}" /></form>
                            <form method="post" action="{{route('print_rentalbike')}}" name="form" style="float: left;margin-right:5px">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-info" value="PRINT" name="print" />
                        <input type="hidden" width="1px" name="id"  value="{{$rentalbike->id}}" /></form>
                    <form method="post" action="{{route('in_rentalbike')}}" name="form">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success" value="RETURNED" name="t" />
                        <input type="hidden" width="1px" name="id"  value="{{$rentalbike->id}}" /></form></td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>

</div>