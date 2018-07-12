<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Info</th>
            <th>pro_with_in-ce</th>
            <th>pro_wout_in-ce</th>
            <th>INFO</th>
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
                        <form method="post" action="{{route('pagent_report')}}" name="form">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-warning" value="NOT PAID" name="t" />
                            <input type="submit" class="btn btn-success" value="PAID" name="p" />
                            <input type="submit" class="btn btn-primary" value="SEARCH" name="search" />
                            <input type="hidden" width="1px" name="id"  value="{{$agent->id}}" /></form> </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>