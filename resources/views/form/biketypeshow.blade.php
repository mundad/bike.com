<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>price_h</th>
            <th>price_h_2</th>
            <th>price_h_3</th>
            <th>price_h_5</th>
            <th>price_d</th>
            <th>insurance</th>
            <th>Izmenit</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($biketypes))
        @foreach($biketypes as $biketype)
            <tr><td>{{$biketype->id}}</td>
                <td>{{$biketype->name}}</td>
                <td>{{$biketype->price_h}}</td>
                <td>{{$biketype->price_h_2}}</td>
                <td>{{$biketype->price_h_3}}</td>
                <td>{{$biketype->price_h_5}}</td>
                <td>{{$biketype->price_d}}</td>
                <td>{{$biketype->insurance}}</td>
                <td><form method="post" action="{{route('change_biketype')}}" name="form">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-warning" value="CHANGE" name="t" />
                        <input type="hidden" width="1px" name="id"  value="{{$biketype->id}}" /></form> </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    <a href="{{route('addform_biketype')}}" class="btn btn-lg btn-success btn-block"> ADD NEW</a>

</div>