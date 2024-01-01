<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!--Style-->
    <style>
        body{
            background-color: white;
        }
        .navbg{
    background-color: rgb(243, 200, 6);
    font-size: large;
    }
    .login{
        border: 1px red;
        border-radius: 10px;
        color:rgb(250, 248, 248);
        background-color: rgb(243, 85, 85);
    }
    .login:hover{
        background-color: white;
        color: red;
        font-weight: 600;
        border: 1px solid red;
        border-radius: 10px;
    }
    .register{
        border: 1px solid rebeccapurple;
        border-radius: 10px;
        color:rgb(252, 254, 255);
        background-color: blue;
    }
    .register:hover{
        background-color: white;
        color: blue;
        font-weight: 600;
        border: 1px solid blue;
        border-radius: 10px;
    }
    
    .file {
        overflow: hidden;
        transition: transform 0.3s ease-in-out; /* Add a smooth transition effect for transform */
        }
    .file:hover {
    transform: scale(1.05); /* Apply a scale transform on hover */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Optional: Add a subtle box shadow for a lifted effect */
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md shadow shadow-5 navbg">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item me-2">
                                    <a class="btn btn-block login" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-block register" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
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
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
