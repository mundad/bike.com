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
        ID<input  class="form-control" placeholder="ALLIES" value="{{old('name')}}"  name="name" type="text" >
    </div>
    <div class="form-group">
        INFO<textarea  class="form-control" placeholder="INFO"  name="info" >{{old('info')}}</textarea>
    </div>
    <div class="form-group">
        PROFIT WITH DISCOUNT<input  class="form-control" placeholder="PROFIT WITH DISCOUN" value="{{old('profit_with_insurance')}}"  name="profit_with_insurance" type="text" >
    </div>
    <div class="form-group">
        PROFIT WITHOUT DISCOUNT<input  class="form-control" placeholder="PROFIT WITHOUT DISCOUNT" value="{{old('profit_without_insurance')}}"  name="profit_without_insurance" type="text" >
    </div>
    <!-- Change this to a button or input when using this as a form -->
    <span id="check_login_all">
    <input type="submit" class="btn btn-lg btn-success btn-block" name="save" value="Save"/>
    </span>
</form>