@extends('layouts.app')

@section('content')

    <? //dd(1);?>
    <div class="container col-12">
        @if($menu)
            {!! $menu !!}
        @endif
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="tile">
                    <div class="col-md-12 text-center">
                        <h3>RENTAL BIKE</h3>
                    </div>
                    <div class="tile-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {!! ($form)?$form:"nest" !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection