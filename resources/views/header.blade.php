<!DOCTYPE html>
<html lang="en">
<head>
    <!-- start: Meta -->
    <meta charset="utf-8">
    <title>Документооборот-имущество</title>
    <meta name="description" content="Bootstrap Metro Dashboard">
    <meta name="author" content="Dennis Ji">
    <meta name="keyword"
          content="">
    <!-- end: Meta -->
    <link href="img/favicon.png" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
    <!-- start: Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- end: Mobile Specific -->
    <!-- start: CSS -->
    <link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link id="base-style" href="css/style.css" rel="stylesheet">
    <link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext'
          rel='stylesheet' type='text/css'>
    <!-- end: CSS -->
    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <link id="ie-style" href="css/ie.css" rel="stylesheet">
    <![endif]-->
    <!--[if IE 9]>
    <link id="ie9style" href="css/ie9.css" rel="stylesheet">
    <![endif]-->
    <!-- start: Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <!-- end: Favicon -->
</head>

<body>
<!-- start: Header -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse"
               data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="/"><span>Белэнерго</span></a>

            <!-- start: Header Menu -->
            <div class="nav-no-collapse header-nav">
                <ul class="nav pull-right">

                    <!-- start: Notifications Dropdown -->
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-calendar"></i>
                        </a>
                        <ul class="dropdown-menu tasks">
                            <li class="dropdown-menu-title">
                                <span>Шаблоны писем</span>
                            </li>
                            @if(\Illuminate\Support\Facades\Auth::user()!=NULL)
                                @if(\Illuminate\Support\Facades\Auth::user()->roles()->first()->role == 'spa' or \Illuminate\Support\Facades\Auth::user()->roles()->first()->role == 'admin')
                                    <li>
                                        <a href="{{ route('makespaletterform') }}">
                                            Создание письма ГПО "Белэнерго"
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                    <!-- end: Notifications Dropdown -->
                    <!-- start: Message Dropdown -->
                    <li class="dropdown hidden-phone">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="icon-envelope"></i>
                        </a>
                        <ul class="dropdown-menu messages">
                            <li class="dropdown-menu-title">
                                <span>Внесение данных</span>
                            </li>
                            @can('create', $completter)
                                <li>
                                    <a href="{{ route('addcompletter') }}">
                                        Внесение ходатайства организации
                                    </a>
                                </li>
                            @endcan
                            @can('create', $spaletter)
                                <li>
                                    <a href="{{ route('addspaletter') }}">
                                        Внесение письма ГПО "Белэнерго"
                                    </a>
                                </li>
                            @endcan
                            @can('create', $order)
                                <li>
                                    <a href="{{ route('addorder') }}">
                                        Внесение приказа Минэнерго
                                    </a>
                                </li>
                            @endcan
                            @can('create', $report)
                                <li>
                                    <a href="{{ route('addreport') }}">
                                        Внесение отчета об исполнении приказа
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
                <!-- start: User Dropdown -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                @endif
                <!-- end: User Dropdown -->
                </ul>
            </div>
            <!-- end: Header Menu -->
        </div>
    </div>
    <div class="navbar-inner">
        <h2>Приложение для контроля оборота документов по вопросам распоряжения государственным имуществом</h2>
    </div>
</div>
<!-- start: Header -->

<div class="container-fluid-full">
    <div class="row-fluid">

        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
    @endif

    <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <li><a href="/"><i class="icon-bar-chart"></i><span
                                    class="hidden-tablet">Оперативная информация</span></a>
                    </li>
                    <li><a href="/table"><i class="icon-align-justify"></i><span
                                    class="hidden-tablet">Сводная таблица</span></a>
                    <li><a href="/search"><i class="icon-align-justify"></i><span class="hidden-tablet">Поиск</span></a>
                    </li>
                    {{-- <li>
                         <a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Dropdown</span><span
                                     class="label label-important"> 3 </span></a>
                         <ul>
                             <li><a class="submenu" href="submenu.html"><i class="icon-file-alt"></i><span
                                             class="hidden-tablet"> Sub Menu 1</span></a></li>
                             <li><a class="submenu" href="submenu2.html"><i class="icon-file-alt"></i><span
                                             class="hidden-tablet"> Sub Menu 2</span></a></li>
                             <li><a class="submenu" href="submenu3.html"><i class="icon-file-alt"></i><span
                                             class="hidden-tablet"> Sub Menu 3</span></a></li>
                         </ul>
                     </li>--}}

                </ul>
            </div>
        </div>
        <!-- end: Main Menu -->

        <noscript>
            <div class="alert alert-block span10">
                <h4 class="alert-heading">Warning!</h4>
                <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a>
                    enabled to use this site.</p>
            </div>
        </noscript>
        <div id="content" class="span10">
