@extends('layouts.app')

@section('content')
    @if($menu)
        {!! $menu !!}
    @endif
   {{-- <div class="col-2 float-lg-left">
        <ul>
            <li><a href="{{route('agentsshow_report')}}">payed agent</a></li>
            <li><a href="{{route('usershow_report')}}">user report</a></li>
        </ul>
    </div>--}}
    <div class="container col-12">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {!! ($form)?$form:"" !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection