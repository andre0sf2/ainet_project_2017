<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="icon" href="/uploads/icon/favicon.ico">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <strong>PrintIT!</strong>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;<li>
                            <a href="{{ route('index') }}"><span class="glyphicon glyphicon-home"></span> Home</a>
                        </li>
                        <li>
                            <a href="{{route('users.list')}}"><span class="glyphicon glyphicon-th-list"></span> Users</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                               aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> Departments <span
                                        class="caret"></span></a>
                            <ul class="dropdown-menu">
                                @foreach($departments as $department)
                                    <li>
                                        <a href="#">{{ $department->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li>
                        <li>
                            <a href="{{ route('about') }}"><span class="glyphicon glyphicon-book"></span> About</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('auth.login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            <li><a href="{{ route('auth.register') }}"><span class="glyphicon glyphicon-new-window"></span> Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative; padding-left: 50px;">
                                    <img src="/uploads/avatars/{{ Auth::user()->profile_photo }}" style="width: 32px; height: 32px; position: absolute; top: 10px; left: 10px; border-radius: 50%;">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('user.show', Auth::user()->id)}}"><span class="glyphicon glyphicon-user"></span> Profile</a>
                                    </li>
                                    @if(Auth::user()->isAdmin())
                                        <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Admin Dashboard</a></li>
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-out"></span> Logout</a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

<footer class="footer navbar-fixed-bottom">
    <div class="container">
        <span class="text-muted">PrintIT! © 2017</span>
        <a href="{{route('about')}}"> About</a>
    </div>
</footer>
</html>
