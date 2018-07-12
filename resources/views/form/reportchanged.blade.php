DATE START:{{ $datestart }}
@set($t,0)

<? //dd($sales); ?>
<form  class="form-group" action="{{route('searchchangerent_report')}}" method="post">
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
            <input class="form-control " type="date" name="date"  value="{{old('date')}}" />
        </div>
        <div class="col-lg-3 form-group" >
            <input class="form-control " type="date" name="date2"  value="{{old('date2')}}" />
        </div>
        <div class="col-lg-3 form-group" >
            <input type="submit" name="search" class="btn btn-primary" value="SEARCH"/>
        </div>
    </div>
</form>

@if(isset($rentalbikes))
    <table class="table table-hover">
        <thead>
            <tr>
                <th>id</th>
                <th>User get phone</th>
                <th>sales</th>
                <th>accessories</th>
                <th>total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentalbikes as $rentalbike)
                <tr>
                    <td>{{ $rentalbike->id }}</td>
                    <td>{{ $rentalbike->user_get->phone }}</td>
                    <td>{{ 'Created:'.$rentalbike->created_at.'/ Deposit:'.$rentalbike->sale->deposit.'/ Payment method:'.$rentalbike->sale->paymant_method.'/ Insurance:'.$rentalbike->sale->insurance.'/ Sub total:'.$rentalbike->sale->totalmath.'/ Discount:'.$rentalbike->sale->dis }}</td>
                    <td>@if(isset($rentalbike->acsor->created_at))
                  {{ 'Created:'.$rentalbike->acsor->created_at.'/ Helmet:'.$rentalbike->acsor->helmet.'/ Lock'.$rentalbike->acsor->lock.'/ Basket:'.$rentalbike->acsor->basket.'/ Baby seat:'.$rentalbike->acsor->baby_seat}}
                    @endif</td>
                    <td>{{ $rentalbike->sale->total }}</td>
                    @if(isset($sales[$rentalbike->id]))
                        @foreach($sales[$rentalbike->id] as $item)
                           <tr class="table-danger">
                            <td></td>
                            <td></td>
                            <td>{{ 'Updated:'.$item['deleted_at'].'/ Deposit:'.$item['deposit'].'/ Payment method:'.$item['paymant_method'].'/ Insurance:'.$item['insurance'].'/ Sub total:'.$item['totalmath'].'/ Discount:'.$item['dis'] }}</td>
                            <td></td>
                            <td>{{$item['total'] }}</td>
                           </tr>
                       @endforeach
                    @endif
                    @if(isset($accessories[$rentalbike->id]))
                        @foreach($accessories[$rentalbike->id] as $item)
                          <tr class="table-danger">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ 'Updated:'.$item['deleted_at'].'/ Helmet:'.$item['helmet'].'/ Lock'.$item['lock'].'/ Basket:'.$item['basket'].'/ Baby seat:'.$item['baby_seat']}}</td>
                            <td></td>
                          </tr>
                        @endforeach
                    @endif
                    @set($t,$t+$rentalbike->sale->total)
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
