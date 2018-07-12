
<form method="post" action="{{route('save_rentalbike')}}" name="form">
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
@if(!empty($agents)&&!empty($biketypes))
    <div class="row">
        <div class="form-group col-md-6">
            <label for="Agent">Agent</label>
            <input type="text" name="agent" required class="form-control" value="{{session('old.agent')}}"  id="Agent" placeholder="Enter agent ID">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="phone">Phone number</label>
            <input   class="form-control" required class="form-control" placeholder="Enter phone number"  value="{{old('phone')}}"  name="phone" id="phone" type="text" >
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input  class="form-control" placeholder="Enter email" value="{{old('email')}}"  name="email" id="email" type="text" >
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input  class="form-control"  placeholder="Enter name" value="{{old('name')}}"  name="name"  id="name" type="text" >
        </div>
        <div class="form-group col-md-6">
            <label for="secondname">Second name</label>
            <input  class="form-control"  placeholder="Enter second name" value="{{old('second_name')}}"  name="second_name"  id="second_name" type="text" >
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="adress">Address</label>
            <input  class="form-control" placeholder="Enter address"value="{{old('address')}}"  name="address"  id="address" type="text" >
        </div>
        <div class="form-group  col-md-6">
            <label for="deposit">Deposit</label>
            <textarea  class="form-control" placeholder="Enter deposit"  name="deposit"  id="deposit">{{old('deposit')}}</textarea>

        </div>
    </div>



    <hr/>
        <div class="col-md-12 text-center">
    <h3>RENTAL AGREEMENT</h3>
        </div>
    <div class="row" id="bikes">
        @foreach($biketypes as $biketype)
            <div class="form-group  col-md-4 float-left">
                <b>{{strtoupper($biketype->name.' count')}}</b><br/>
                <input name='qty_{{$biketype->id}}' id='qty_{{$biketype->id}}' value="{{old('qty_'.$biketype->id)}}" type="number"  class="form-control" onchange="change_qty({{ $biketype->id }})">
                {{--<input type="button" onclick="alert(bike[k])">--}}
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="form-group  col-md-4 float-left">
            <b>HOURS</b><br/>
        <input name='hrs' id='hrs' value="{{old('hrs')}}" type="number"  class="form-control"  >
        </div><div class="form-group col-md-4 float-left">
            <b>TIME OUT</b><br/>
        <input name='time_out' id='time_out' value="{{old('time_out')}}"  class="form-control"   type="date">
        </div><div class="form-group col-md-4 float-left">
            <b>TIME IN</b><br/>
            <input name='time_in' id='time_in' value="{{old('time_in')}}"  class="form-control"   type="date">
        </div>
    </div>
    <hr/>
        <div class="col-md-12 text-center">
            <h3>ACCESSORIES</h3>
        </div>
    <div class="row">

        <table class="table table-striped table-bordered">
            <thead>
            <tr class="active">
                <th>Helmet</th>
                <th>Lock.</th>
                <th>Basket</th>
                <th>Baby seat</th>
            </tr>
            </thead>
            <tbody>
            <tr class="active">
                <td >
                    <input type="number" class="form-control" id="helmet" value="{{old('helmet')}}"    name="helmet" placeholder="Enter count">
                </td>
                <td>
                    <input type="number" class="form-control" id="lock" value="{{old('lock')}}"  name="lock"  placeholder="Enter count">
                </td>
                <td>
                    <input type="number" class="form-control" id="basket" value="{{old('basket')}}"  name="basket" placeholder="Enter count">
                </td>
                <td>
                    <input type="number" class="form-control" id="babyseat" value="{{old('baby_seat')}}"  name="baby_seat" placeholder="Enter count">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
        <hr/>
    <div class="form-group">
        <div class="col-md-12 text-center">
            <h3>PAYMAENT METHOD</h3>
        </div>
        <div class="col-md-6">
            <table class="table table-striped table-bordered">
                <thead>
                <tr class="warning">
                    <th>Cash</th>
                    <th>Card</th>
                </tr>
                </thead>
                <tbody>
                <tr class="warning">
                    <td>
                        <div class="col-md-3">
                            <input type="radio" class="" checked  value="1" name="pay" checked >
                        </div>
                    </td>
                    <td>
                        <div class="col-md-3">
                            <input type="radio" class="" value="2"  name="pay">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="total" >
            <table class="table table-striped table-bordered">
                <thead>
                <tr class="warning">
                    <th>Sub Total</th>
                    <th>Discount</th>
                    <th>Sub Total with Discount</th>
                    <th>Insurance</th>
                    <th>
                        <input type="checkbox" id="taxx" name="tax" value="1" checked>
                        Tax@ {{ $tax }}
                    </th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr class="warning">
                    <td >
                        <input disabled type="number" value="{{old('sub_total')?old('sub_total'):1}}"  name="sub_total"   class="form-control" id="sb_t" >
                    </td>
                    <td >
                        <input  type="number" class="form-control" value="{{session('old.dis')?session('old.dis'):1}}"  name="dis" id="dis" >
                    </td>
                    <td >
                        <input  disabled type="number" class="form-control" id="sb_t_w_d" >
                    </td>
                    <td >
                        <input  type="number" name="insurance" value="{{session('old.insurance')?session('old.insurance'):1}}" class="form-control" id="ins" >
                    </td>
                    <td>
                        <input disabled type="number"  value="{{old('tax')?old('tax'):1}}"  name="tax" class="form-control" id="tax" >
                    </td>
                    <td>
                        <input type="number" placeholder="TOTAL" value="{{old('total')}}"  name="total" class="form-control" id="total" >
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Change this to a button or input when using this as a form -->
    <span id="check_login_all">
        <button class="btn btn-primary" id="test" type="button"><i class="fa fa-save"></i>test</button>&nbsp;&nbsp;<button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>Save</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" onclick="window.refresh()" href=""><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>

    </span>
@else
        <div class="alert alert-danger">
            ERROR
        </div>
@endif
    <script src="{{ asset('js/app_scripts.js') }}"></script>
</form>
