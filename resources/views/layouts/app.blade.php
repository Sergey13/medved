<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name='csrf-token' content="{{csrf_token()}}">

    <title>Белый медведь</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet'
          type='text/css'>
    <!--    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>-->
    <link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>
    <!-- Application fonts -->
    <link href="/fonts/awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href='/css/polarbearfonts/flaticon.css' rel='stylesheet' type="text/css">

    <!-- jQuery Datepicker style-->
    <link href='/library/datepicker/jquery-ui.min.css' rel='stylesheet' type='text/css'>
    <link href='/library/datepicker/jquery-ui.theme.min.css' rel='stylesheet' type='text/css'>

    <!-- Fancybox style-->
    <link href='/library/fancybox/jquery.fancybox.css' rel='stylesheet' type='text/css'>

    <!-- Chosen style-->
    <link href='/library/chosen/chosen.min.css' rel='stylesheet' type='text/css'>

    <!-- Application styles-->
    <link href='/css/app.css' rel='stylesheet' type='text/css'>

</head>
<body id="app-layout">
@if(Auth::guest())
    <div class='first-page'>
        <div class='content text-center'>
            @yield('content')
        </div>
    </div>
@else
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">

                <!-- Branding Image -->
                <a class="navbar-brand main-logo logo-small" href="{{ url('/') }}">
                </a>
            </div>

            <!-- Left Side Of Navbar -->
            <ul class="main-menu">
                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('director'))
                    <li>
                        <a data-href="/equipment" data-name='equipment' title="Список и место установки оборудования"
                           class="active" data-toggle="tooltip" data-placement="bottom">
                            <span class="active-line"></span>
                            <i class='flaticon-document259'></i>
                        </a>
                    </li>
                    <li>
                        <a data-href="/components" data-name='components' title="Составляющие" data-toggle="tooltip"
                           data-placement="bottom">
                            <span class="active-line"></span>
                            <i class='flaticon-marketing8'></i>
                        </a>
                    </li>
                    {{--<li>--}}
                        {{--<a data-href="/places" data-name='places' title="Список мест установки оборудования" data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<span class="active-line"></span>--}}
                            {{--<i class='fa fa-industry'></i>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li><a data-href="/schedule" data-name='schedule' title="Календарь ППР" data-toggle="tooltip"
                           data-placement="bottom">
                            <span class="active-line"></span>
                            <i class='flaticon-calendar68'></i>
                        </a></li>
                @endif
                <li><a data-href="/stock/equipments" data-name='stock' title="Склад" data-toggle="tooltip"
                       data-placement="bottom">
                        <span class="active-line"></span>
                        <i class='flaticon-commercial15'></i>
                    </a>
                    <a class='empty-stock hide' title="Необходимо пополнить склад" data-toggle="tooltip"
                       data-placement="left">
                        <i class='fa fa-battery-quarter'></i>
                    </a>
                </li>
                <li><a data-href="/performers" data-name='performers' title="Исполнители" data-toggle="tooltip"
                       data-placement="bottom">
                        <span class="active-line"></span>
                        <i class='flaticon-business139'></i>
                    </a></li>

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="main-menu menu-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Вход</a></li>
                @else
                    <li>
                        <a class='notifications' data-toggle="tooltip" data-placement="bottom" title="Напоминания">
                            <i class="fa fa-bell-o notifications"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/logout') }}" title="Выйти с административной панели" data-toggle="tooltip"
                           data-placement="bottom"><i class="flaticon-logout13"></i></a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
    <div class="admin-page active">
        @yield('content')
    </div>

    <div class="admin-page no-active">

    </div>
@endif

<div class='load-page coffee'>
    <div class="cssload-coffee">
    </div>
</div>

<div class='load-page cube'>
    <div class="cssload-preloader cssload-loading">
        <span class="cssload-slice"></span>
        <span class="cssload-slice"></span>
        <span class="cssload-slice"></span>
        <span class="cssload-slice"></span>
        <span class="cssload-slice"></span>
        <span class="cssload-slice"></span>
    </div>
</div>

<div class='load-page loader'>
    <div class="cssload-loader">Загрузка</div>
</div>


<div class="block-notifications" id="block-notifications">
</div>

<div class='balance-notifications' id='balance-notifications'>
</div>

<!-- JavaScripts -->
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

<script src="/library/jQuery-File-Upload-9.12.1/js/vendor/jquery.ui.widget.js"></script>
<script src="/library/jQuery-File-Upload-9.12.1/js/jquery.iframe-transport.js"></script>
<script src="/library/jQuery-File-Upload-9.12.1/js/jquery.fileupload.js"></script>


<script src="/library/bootstrap/javascripts/bootstrap.min.js"></script>

<!--jQuery maskedinput script-->
<script src='/library/maskedinput/jquery.maskedinput.min.js'></script>

<!--Datepicker script-->
<script src="/library/datepicker/jquery-ui.min.js"></script>

<!--Backbone && Undescore-->
<script src='/library/backbone/underscore.js'></script>
<script src='/library/backbone/backbone.js'></script>

<!--Fancybox script-->
<script src="/library/fancybox/jquery.fancybox.pack.js"></script>

<!--Chosen script-->
<script src="/library/chosen/chosen.jquery.js"></script>

@if (!Auth::guest())
    <script src="/js/admin.js"></script>
    <script src="/js/search.js"></script>
@endif

</body>
</html>
