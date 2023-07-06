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
    <link href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" rel="stylesheet"/>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{--initialize file if is in this url--}}
    @if( Route::currentRouteName() === '/' ||  Route::currentRouteName() === 'home' || Route::currentRouteName() == 'share_link.modal')
        <script src="{{ asset('js/propose_event_google_maps.js') }}"></script>
    @endif

    <script src="{{ asset('js/home.js') }}"></script>

</head>
<body class="d-flex flex-column min-vh-100">
<div id="app">
    <nav class="navbar navbar-expand-md" style="margin-bottom: 50px; margin-top: 50px;">

        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="me-auto">
                    <div class="logo">
                        <a href="{{url('/')}}" class="logo-link">
                            <svg id="logo-eco-4" viewBox="0 0 23 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.82 22.15V15.675L11.25 0.799999H19.615V15.43H22.135V22.15H19.615V26H11.775V22.15H0.82ZM12.405 9.655L8.625 15.43H12.405V9.655Z"
                                    fill="#A6CE39"/>
                            </svg>

                            <svg id="eco-logo-top" viewBox="0 0 78 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.15"
                                      d="M26.232 13.798C26.232 14.5033 26.186 15.2087 26.094 15.914H9.028C9.12 17.3247 9.50333 18.3827 10.178 19.088C10.8833 19.7627 11.7727 20.1 12.846 20.1C14.3487 20.1 15.422 19.4253 16.066 18.076H25.68C25.2813 19.8547 24.4993 21.4493 23.334 22.86C22.1993 24.24 20.758 25.3287 19.01 26.126C17.262 26.9233 15.33 27.322 13.214 27.322C10.6687 27.322 8.39933 26.7853 6.406 25.712C4.44333 24.6387 2.89467 23.1053 1.76 21.112C0.656 19.1187 0.104 16.7727 0.104 14.074C0.104 11.3753 0.656 9.04467 1.76 7.082C2.864 5.08867 4.39733 3.55533 6.36 2.482C8.35333 1.40867 10.638 0.871999 13.214 0.871999C15.7593 0.871999 18.0133 1.39333 19.976 2.436C21.9387 3.47867 23.472 4.98133 24.576 6.944C25.68 8.876 26.232 11.1607 26.232 13.798ZM17.032 11.544C17.032 10.44 16.664 9.58133 15.928 8.968C15.192 8.324 14.272 8.002 13.168 8.002C12.064 8.002 11.1593 8.30867 10.454 8.922C9.74867 9.50467 9.28867 10.3787 9.074 11.544H17.032ZM25.4497 14.074C25.4497 11.406 26.0017 9.07533 27.1057 7.082C28.2097 5.08867 29.743 3.55533 31.7057 2.482C33.699 1.40867 35.9684 0.871999 38.5137 0.871999C41.795 0.871999 44.555 1.77667 46.7937 3.586C49.0324 5.36467 50.4737 7.864 51.1177 11.084H41.5497C40.9977 9.39733 39.9244 8.554 38.3297 8.554C37.195 8.554 36.2904 9.02933 35.6157 9.98C34.9717 10.9 34.6497 12.2647 34.6497 14.074C34.6497 15.8833 34.9717 17.2633 35.6157 18.214C36.2904 19.1647 37.195 19.64 38.3297 19.64C39.955 19.64 41.0284 18.7967 41.5497 17.11H51.1177C50.4737 20.2993 49.0324 22.7987 46.7937 24.608C44.555 26.4173 41.795 27.322 38.5137 27.322C35.9684 27.322 33.699 26.7853 31.7057 25.712C29.743 24.6387 28.2097 23.1053 27.1057 21.112C26.0017 19.1187 25.4497 16.7727 25.4497 14.074ZM63.8691 27.322C61.2931 27.322 58.9778 26.7853 56.9231 25.712C54.8991 24.6387 53.3044 23.1053 52.1391 21.112C50.9738 19.1187 50.3911 16.7727 50.3911 14.074C50.3911 11.406 50.9738 9.07533 52.1391 7.082C53.3351 5.08867 54.9451 3.55533 56.9691 2.482C59.0238 1.40867 61.3391 0.871999 63.9151 0.871999C66.4911 0.871999 68.7911 1.40867 70.8151 2.482C72.8698 3.55533 74.4798 5.08867 75.6451 7.082C76.8411 9.07533 77.4391 11.406 77.4391 14.074C77.4391 16.742 76.8411 19.088 75.6451 21.112C74.4798 23.1053 72.8698 24.6387 70.8151 25.712C68.7604 26.7853 66.4451 27.322 63.8691 27.322ZM63.8691 19.502C65.1264 19.502 66.1691 19.042 66.9971 18.122C67.8558 17.1713 68.2851 15.822 68.2851 14.074C68.2851 12.326 67.8558 10.992 66.9971 10.072C66.1691 9.152 65.1418 8.692 63.9151 8.692C62.6884 8.692 61.6611 9.152 60.8331 10.072C60.0051 10.992 59.5911 12.326 59.5911 14.074C59.5911 15.8527 59.9898 17.202 60.7871 18.122C61.5844 19.042 62.6118 19.502 63.8691 19.502Z"
                                      fill="black"/>
                            </svg>
                        </a>
                    </div>

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link action-button" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link action-button" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else

                        @if(auth()->check() && (auth()->user()->role == 'partner' || auth()->user()->role == 'admin'))
                            <li class="nav-item">
                                <a class="nav-link action-button"
                                   href="{{ route('event-locations.index') }}">{{ __('Creaza loc Ecologizare') }}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link action-button"
                                   href="{{ route('propose-locations.index') }}">{{ __('Actiuni Ecologizare') }}</a>
                            </li>

                        @elseif(auth()->check() && (auth()->user()->role == 'coordinator'))
                            <li class="nav-item action-button">
                                <a style="color:green" class="nav-link"
                                   href="{{ route('coordinator.event') }}">{{ __('Actiuni Ecologizare') }}</a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle action-button" href="#"
                               role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item action-button" href="{{ route('logout') }}"
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
                    <li class="nav-item">

                        <div id="button-container" class="text-right"
                             style="text-align: right !important;">
                            <div
                                style="
									font-size: 12px;
									color: #ccc;
									margin-top: -7px;
									margin-right: 35px;
									height: 30px;
									vertical-align: middle;
    							padding-top: 18px;">
                                Suntem prezenți pe:
                            </div>

                            <a href="https://www.facebook.com/planteazainromania" target="_blank">
                                <svg id="fb" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 68.63 68.63"
                                     style="height: 28px; margin-top: -16px;" height="28">
                                    <path
                                        d="M73.19,267.1H71.84A6,6,0,0,0,71,267a33.25,33.25,0,0,1-12.67-3,34.29,34.29,0,0,1-19.6-36.86,32.82,32.82,0,0,1,8.47-17.4c8.76-9.3,19.57-12.84,32.11-10.52a32.75,32.75,0,0,1,20,12.21,33.25,33.25,0,0,1,7.29,17.78c.1,1,.19,1.94.29,2.92v1.34c-.05.3-.11.61-.15.91-.2,1.75-.25,3.53-.62,5.24a33.89,33.89,0,0,1-16.73,23A32.37,32.37,0,0,1,74.1,267,9.09,9.09,0,0,0,73.19,267.1Zm8.86-41h-.82c-1.81,0-3.63,0-5.44,0-.51,0-.71-.11-.69-.67,0-1.29,0-2.59,0-3.89a1.83,1.83,0,0,1,2.06-2.06h4.3c.39,0,.62-.07.62-.55q0-3.39,0-6.77c0-.41-.16-.56-.56-.56-2.74,0-5.5-.05-8.23.17a7.72,7.72,0,0,0-6.63,4.56,11.71,11.71,0,0,0-1,4.87c0,1.41,0,2.82,0,4.23,0,.54-.17.69-.69.67-1.05,0-2.1,0-3.15,0-.43,0-.6.14-.6.58,0,2.3,0,4.61,0,6.91,0,.47.21.56.61.55,1,0,2,0,3,0,.67,0,.81.21.81.84,0,6.88,0,13.77,0,20.66,0,1,0,1,1,1h7.52c1,0,1,0,1-.94,0-7,0-13.91,0-20.87,0-.54.13-.74.71-.73,1.58,0,3.17,0,4.76,0,.49,0,.73-.09.73-.65a17.8,17.8,0,0,1,.19-1.79C81.67,229.88,81.85,228.06,82.05,226.11Z"
                                        transform="translate(-38.24 -198.47)" style="fill:#4080ff"></path>
                                    <path
                                        d="M82.05,226.11c-.2,1.95-.38,3.77-.56,5.59a17.8,17.8,0,0,0-.19,1.79c0,.56-.24.66-.73.65-1.59,0-3.18,0-4.76,0-.58,0-.71.19-.71.73,0,7,0,13.91,0,20.87,0,.94,0,.94-1,.94H66.63c-1,0-1,0-1-1,0-6.89,0-13.78,0-20.66,0-.63-.14-.88-.81-.84-1,.06-2,0-3,0-.4,0-.61-.08-.61-.55,0-2.3,0-4.61,0-6.91,0-.44.17-.58.6-.58,1.05,0,2.1,0,3.15,0,.52,0,.7-.13.69-.67,0-1.41,0-2.82,0-4.23a11.71,11.71,0,0,1,1-4.87,7.72,7.72,0,0,1,6.63-4.56c2.73-.22,5.49-.12,8.23-.17.4,0,.56.15.56.56q0,3.38,0,6.77c0,.48-.23.55-.62.55h-4.3a1.83,1.83,0,0,0-2.06,2.06c0,1.3,0,2.6,0,3.89,0,.56.18.68.69.67,1.81,0,3.63,0,5.44,0Z"
                                        transform="translate(-38.24 -198.47)" style="fill:#ffffff"></path>
                                </svg>
                            </a>
                        </div>
                    </li>
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
                            <a href="#" data-bs-toggle="modal" class="link-style" data-bs-target="#aboutUsModal">Despre proiect</a>
                        </li>

                        <li>border
                            <a href="#" data-bs-toggle="modal" class="link-style" data-bs-target="#contactModal">Contact</a>
                        </li>

                        <li>
                            <a href="#" data-bs-toggle="modal" class="link-style" data-bs-target="#tandc">Termeni și condiții</a>
                        </li>

                        <li>
                            <a href="#" data-bs-toggle="modal" class="link-style" data-bs-target="#pandc">Politica de
                                confidențialitate</a>
                        </li>
                    </ul>
                </div>

                <div class="footer-copyright">
                    <p style="color:rgb(124, 121, 121)">2016 - 2022 Toate drepturile Creștem România Împreună</p>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>


