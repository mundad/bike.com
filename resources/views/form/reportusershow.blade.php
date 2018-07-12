<div class="table-responsive">
    Start date:{{ $datestart }}
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Login</th>
            <th>email</th>
            <th>name</th>
            <th>total</th>
            <th>INFO-REPORT</th>
            <? //dd(1);?>
        </tr>
        </thead>
        <tbody>
        @if(!empty($users))
            @foreach($users as $user)
                <tr><td>{{$user->id}}</td>
                    <td>{{$user->login}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$utotal[$user->id]}}</td>
                    <td>
                        <form method="post" action="{{route('ruser_report')}}" name="form" class="col-12">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-warning" value="NOT RETURNED" name="t" />
                            <input type="submit" class="btn btn-success" value="RETURNED" name="p" />
                            <input type="submit" class="btn btn-warning" value="RENT CHANGED" name="c" />
                            <input type="submit" class="btn btn-primary" value="SEARCH" name="search" />
                            <input type="hidden" width="1px" name="id"  value="{{$user->id}}" /></form> </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>