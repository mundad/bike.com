<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- shablon --->

    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (!empty($title))?$title:'General' }}</title>

    <!-- Scripts -->{{--
    <script src="{{ asset('js/print.min.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->{{--
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">--}}

    <!-- Styles
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body class="app sidebar-mini rtl">

<header class="app-header"><a class="app-header__logo" href="index.html">Bike.io</a>
        <!-- User Menu-->
        @guest
            <!-- Navbar Right Menu-->
    <ul class="app-nav">
            <li>
                <a class="app-nav__item" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            {{--<li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>--}}
    </ul>
</header>
<main>
    @yield('content')
</main>
        @else
            <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- Navbar Right Menu-->
            <ul class="app-nav">
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa fa-user fa-lg"> </i> <span class="caret">{{ Auth::user()->name }}</span></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-lg"></i>  {{ __('Logout') }}Logout</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
            </ul>
            </header>
            <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
            <aside class="app-sidebar">
                <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('img/avatar5.png') }}" alt="User Image" style="width: 50px">
                    <div>
                        <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
                        <p class="app-sidebar__user-designation">{{ Auth::user()->roles()->first()->name }}</p>
                    </div>
                </div>
                <ul class="app-menu">
                    <li><a class="app-menu__item {{ Route::current()->getName()=='home'?'active':''}} " href="{{route('home')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
                    <li class="treeview {{ Route::current()->getName()=='show_rentalbike'||Route::current()->getName()=='addform_rentalbike'||Route::current()->getName()=='print_rentalbike'|| Route::current()->getName()=='change_rentalbike'|| Route::current()->getName()=='search_rentalbike'?'is-expanded':''}} "><a class="app-menu__item  " href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-bicycle"></i><span class="app-menu__label">Rental Bikes</span></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item {{ Route::current()->getName()=='show_rentalbike'|| Route::current()->getName()=='change_rentalbike'|| Route::current()->getName()=='search_rentalbike'?'active':''}}" href="{{route('show_rentalbike')}}"  ><i class="icon  fa-sticky-note-o"></i> Show rental</a></li>
                            <li><a class="treeview-item {{ Route::current()->getName()=='addform_rentalbike'||Route::current()->getName()=='print_rentalbike'?'active':''}}" href="{{route('addform_rentalbike')}}"  ><i class="icon fa fa-plus-square-o"></i> Add new rental</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->roles()->first()->name=='admin')
                    <li class="treeview {{ Route::current()->getName()=='show_report'|| Route::current()->getName()=='agentsshow_report'||Route::current()->getName()=='pagent_report'||Route::current()->getName()=='paidsearch_report'||Route::current()->getName()=='savepaid_report'|| Route::current()->getName()=='usershow_report'?'is-expanded':''}} "><a  data-toggle="treeview" class="app-menu__item {{ Route::current()->getName()=='show_report'?'active':''}} " href="{{ route('show_report') }}"><i class="app-menu__icon fa fa-address-card-o"></i><span class="app-menu__label">Reports</span></a>
                        <ul class="treeview-menu">
                            <li><a class="treeview-item {{ Route::current()->getName()=='agentsshow_report'||Route::current()->getName()=='pagent_report'||Route::current()->getName()=='paidsearch_report'||Route::current()->getName()=='savepaid_report'?'active':''}}" href="{{route('agentsshow_report')}}"><i class="icon fa fa-circle-o"></i> paid agent</a></li>
                            <li><a class="treeview-item {{ Route::current()->getName()=='usershow_report'?'active':''}}" href="{{route('usershow_report')}}"><i class="icon fa fa-circle-o"></i> User report</a></li>
                        </ul>
                    </li>
                    <li><a class="app-menu__item {{ Route::current()->getName()=='show_agent'?'active':''}} " href="{{ route('show_agent') }}"><i class="app-menu__icon fa fa-industry"></i><span class="app-menu__label">Agents</span></a></li>
                    <li><a class="app-menu__item {{ Route::current()->getName()=='show_biketype'?'active':''}} " href="{{ route('show_biketype') }}"><i class="app-menu__icon fa fa-bicycle"></i><span class="app-menu__label">Bike types</span></a></li>
                    @endif
                </ul>
            </aside>

            <main class="app-content">
                @yield('content')
                <div style="height: 100px"></div>
            </main>
        @endguest

<!-- Essential javascripts for application to work-->
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/plugins/test.js')}}"></script>
<script src="{{asset('js/print_check.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('js/plugins/pace.min.js')}}"></script>
<!-- Page specific javascripts-->
<script type="text/javascript" src="{{asset('js/plugins/chart.js')}}"></script>
<script type="text/javascript">
    var data = {
        labels: ["January", "February", "March", "April", "May"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86]
            }
        ]
    };
    var pdata = [
        {
            value: 300,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Complete"
        },
        {
            value: 50,
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "In-Progress"
        }
    ]
/*
    var ctxl = $("#lineChartDemo").get(0).getContext("2d");
    var lineChart = new Chart(ctxl).Line(data);

    var ctxp = $("#pieChartDemo").get(0).getContext("2d");
    var pieChart = new Chart(ctxp).Pie(pdata);*/
</script>
<!-- Google analytics script-->
<script type="text/javascript">
    if(document.location.hostname == 'pratikborsadiya.in') {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72504830-1', 'auto');
        ga('send', 'pageview');
    }
</script>

<!-- end shablon-->
</body>
</html>
