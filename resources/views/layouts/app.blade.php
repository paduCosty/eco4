<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/eco4-fe.css') }}">
    <link href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" rel="stylesheet" />



    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ asset('js/propose_event.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>


</head>
<body class="d-flex flex-column min-vh-100">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        {{--        @include('admin.sidebar.sidebar')--}}

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item">
                            <a style="color:green" class="nav-link"
                               href="{{ route('event-locations.index') }}">{{ __('Creaza loc Ecologizare') }}</a>
                        </li>

                        <li class="nav-item">
                            <a style="color:green" class="nav-link"
                               href="{{ route('propose-locations.index') }}">{{ __('Evenimente propuse') }}</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a style="color:green" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
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

@include('components.modals.about_us_modal')
@include('components.modals.contact_us_modal')
@include('components.modals.terms_and_conditions_modal')
@include('components.modals.privacy_policy')

<footer class="mt-auto">
    <div class="container footer-container mt-1">
        <div class="row">
            <div class="col-12" style="text-align: center;">
                <div class="footer-menu">
                    <ul>

                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#aboutUsModal">Despre proiect</a>
                        </li>

                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#contactModal">Contact</a>
                        </li>

                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#tandc">Termeni și condiții</a>
                        </li>

                        <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#pandc">Politica de
                                confidențialitate</a>
                        </li>
                    </ul>
                </div>

                <div class="footer-copyright">
                    <p  style="color:rgb(124, 121, 121)">2016 - 2022 Toate drepturile Creștem România Împreună</p>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>


