<? //dd(session()->all());?>
@if($agent)
    <form method="post" action="{{route('save_agent')}}" name="form">
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
        <div class="form-group">
            ID<input  class="form-control" placeholder="ALLIES" value="{{(session('old.name'))}}"  name="name" type="text" readonly >
        </div>
        <div class="form-group">
            INFO<textarea  class="form-control" placeholder="INFO"   name="info" >{{session('old.info')}}</textarea>
        </div>
        <div class="form-group">
            PROFIT WITH DISCOUNT<input  class="form-control" placeholder="PROFIT WITH DISCOUNT" type="text"  name="profit_with_insurance" value="{{session('old.profit_with_insurance')}}">
        </div>
        <div class="form-group">
            PROFIT WITHOUT DISCOUNT<input  class="form-control" placeholder="PROFIT WITHOUT DISCOUNT" type="text"  name="profit_without_insurance" value="{{session('old.profit_without_insurance')}}">
        </div>
        <!-- Change this to a button or input when using this as a form -->
        <span id="check_login_all">
            <button class="btn btn-lg btn-success " name="save"><i class="fa fa-save"></i>SAVE </button>
            <button class="btn btn-lg btn-danger" name="delete"><i class="fa fa-trash"></i> DELETE</button>
        <input type="hidden" width="1px" name="id"  value="{{$agent}}" />
    </span>
    </form>
@endif