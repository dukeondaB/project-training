<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, AdminWrap lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, AdminWrap lite design, AdminWrap lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="AdminWrap Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>@yield('title')</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/adminwrap-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/node_modules/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">

    <link href="{{asset('assets/node_modules/morrisjs/morris.css')}}" rel="stylesheet">
    <!--c3 CSS -->
    <link href="{{asset('assets/node_modules/c3-master/c3.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="{{asset('css/pages/dashboard1.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/default.css')}}" id="theme" rel="stylesheet">

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
{{--    <div class="preloader">--}}
{{--        <div class="loader">--}}
{{--            <div class="loader__figure"></div>--}}
{{--            <p class="loader__label">Admin Wrap</p>--}}
{{--        </div>--}}
{{--    </div>--}}

    <div id="main-wrapper">

        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">

                <div class="navbar-header">
                    <a class="navbar-brand" href="{{route('dashboard')}}">
                        <!-- Logo icon --><b>

                            <img src="{{asset('../assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{asset('../assets/images/logo-light-icon.png')}}" alt="homepage" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                            <!-- dark Logo text -->
                            <img src="{{asset('../assets/images/logo-text.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="{{asset('../assets/images/logo-light-text.png')}}" class="light-logo" alt="homepage" /></span>
                    </a>
                </div>
                <div class="navbar-collapse">


                    <ul class="navbar-nav me-auto">
                        <a href="{!! route('user.change-language', ['en']) !!}">English</a>
                        <a href="{!! route('user.change-language', ['vi']) !!}">Vietnam</a>
                        
                        {{--                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"--}}
{{--                                href="javascript:void(0)"><i class="fa fa-bars"></i></a> </li>--}}

{{--                        <li class="nav-item hidden-xs-down search-box"> <a--}}
{{--                                class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i--}}
{{--                                    class="fa fa-search"></i></a>--}}
{{--                            <form class="app-search">--}}
{{--                                <input type="text" class="form-control" placeholder="Search & enter"> <a--}}
{{--                                    class="srh-btn"><i class="fa fa-times"></i></a></form>--}}
{{--                        </li>--}}
                    </ul>

                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                        </li>
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                                id="navbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="{{ asset('storage/images/user/' . $user->avatar) }}" alt="user" class="" /> <span
                                    class="hidden-md-down">{{$user->full_name}} &nbsp;</span> </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="{{url('dashboard')}}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">{{__('Dashboard')}}</span></a>
                        </li>
                        @can('admin-access', Auth()->user())
                        <li> <a class="waves-effect waves-dark" href="{{url('user')}}" aria-expanded="false"><i
                                    class="fa fa-briefcase"></i><span class="hide-menu">{{__('User')}}</span></a>
                        </li>
                        @endcan
                        <li> <a class="waves-effect waves-dark" href="{{url('/profile')}}" aria-expanded="false"><i
                                    class="fa fa-user-circle-o"></i><span class="hide-menu">{{__('Profile')}}</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('department-list')}}" aria-expanded="false"><i
                                    class="fa fa-graduation-cap"></i><span class="hide-menu">{{__('Department')}}</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="{{route('course-list')}}" aria-expanded="false"><i
                                    class="fa fa-briefcase"></i><span class="hide-menu">{{__('Course')}}</span></a>
                        </li>

                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link"  href="{{ route('login') }}"><i class="fa fa-window-close
"></i>{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"><i class="fa fa-window-close
"></i>{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="">
{{--                                <a id="navbarDropdown" class="" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                    {{ Auth::user()->name }}--}}
{{--                                </a>--}}

                                <div class="">
                                    <a class="" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                    </ul>

                </nav>
            </div>
        </aside>

        <div class="page-wrapper">

            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">@yield('title')</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">@yield('title')</a></li>
                            <li class="breadcrumb-item active">@yield('sub-title')</li>
                        </ol>
                    </div>
                    <br>
                    <br>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-warning">
                        {{ session('error') }}
                    </div>
                @endif
        @yield('content')
            </div>
    </div>
    </div>

    <script src="{{asset('assets/node_modules/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{asset('assets/node_modules/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>

    <script src="{{asset("assets/node_modules/raphael/raphael-min.js")}}"></script>
    <script src="{{asset('assets/node_modules/morrisjs/morris.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/d3/d3.min.js')}}"></script>
    <script src="{{asset('assets/node_modules/c3-master/c3.min.js')}}"></script><script src="{{asset('js/dashboard1.js')}}"></script>
</body>

</html>
