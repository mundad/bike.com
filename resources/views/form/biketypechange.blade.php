<? //dd(session()->all());?>

<form method="post" action="{{route('save_biketype')}}" name="form">
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
        NAME<input  class="form-control" placeholder="NAME" value="{{(session('old.name'))}}"  name="name" type="text" readonly>
    </div>
    <div class="form-group">
        INFO<textarea  class="form-control" placeholder="INFO"   name="info" >{{session('old.info')}}</textarea>
    </div>
    <div class="form-group">
        PRICE_H<input  class="form-control"  value="{{session('old.price_h')}}"   placeholder="PRICE_H" name="price_h" type="text">
    </div>
    <div class="form-group">
        PRICE_H_2<input  class="form-control"  value="{{session('old.price_h_2')}}"   placeholder="PRICE_H_2" name="price_h_2" type="text">
    </div>
    <div class="form-group">
        PRICE_H_3<input  class="form-control"  value="{{session('old.price_h_3')}}"   placeholder="PRICE_H_3" name="price_h_3" type="text">
    </div>
    <div class="form-group">
        PRICE_H_5<input  class="form-control"  value="{{session('old.price_h_5')}}"   placeholder="PRICE_H_5" name="price_h_5" type="text">
    </div>
    <div class="form-group">
        PRICE_D<input  class="form-control"  value="{{session('old.price_d')}}"   placeholder="PRICE_D" name="price_d" type="text">
    </div>
    <div class="form-group">
        INSURANCE<input  class="form-control"  value="{{session('old.insurance')}}"   placeholder="INSURANCE" name="insurance" type="text">
    </div>
    <!-- Change this to a button or input when using this as a form -->
    <span id="check_login_all">
        <input type="submit" class="btn btn-lg btn-success " name="save" value="SAVE"/>
        <input type="submit" class="btn btn-lg btn-danger" name="delete" value="DELETE"/>
        <input type="hidden" width="1px" name="id"  value="{{$biketype}}" />
    </span>
</form>
