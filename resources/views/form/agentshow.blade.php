
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Info</th>
            <th>pro with DIS</th>
            <th>pro wout DIS </th>
            <th>Change</th>
            <? //dd(1);?>
        </tr>
        </thead>
        <tbody>
        @if(!empty($agents))
        @foreach($agents as $agent)
            <tr><td>{{$agent->id}}</td>
                <td>{{$agent->name}}</td>
                <td>{{str_limit($agent->info,100)}}...</td>
                <td>{{$agent->profit_with_insurance}}</td>
                <td>{{$agent->profit_without_insurance}}</td>
                <td>
                    <form method="post" action="{{route('change_agent')}}" name="form">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-warning" value="CHANGE" name="t" />
                        <input type="hidden" width="1px" name="id"  value="{{$agent->id}}" /></form> </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    <a href="{{route('addform_agent')}}" class="btn btn-lg btn-success btn-block"> ADD NEW</a>

</div>