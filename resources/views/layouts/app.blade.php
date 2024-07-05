<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Bot') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <!-- Right Side Of Navbar -->


    <!-- This closes your navbar-collapse div -->
    @auth
        <div class="container-fluid overflow-hidden">
            <div class="row  overflow-auto">
                <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
                    <div
                        class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                        <a href="/"
                            class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                            <span class="fs-5">Bot<span class=" ms-2 d-none d-sm-inline"><img
                                        src="{{ url('storage/images/bot-TG.jpg') }}" alt="hugenerd" width="28"
                                        height="28" class="rounded-circle"></span></span>
                        </a>
                        <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start"
                            id="menu">
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="nav-link px-sm-0 px-2">
                                    <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-sm-0 px-2">
                                    <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Orders</span></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" id="dropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fs-5 bi-bootstrap"></i><span class="ms-1 d-none d-sm-inline">Services</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                    <li><a class="dropdown-item" href="{{ url('create') }}">Update Countries</a></li>
                                    <li><a class="dropdown-item" href="#">Issue Tickets</a></li>
                                    <li><a class="dropdown-item" href="#">Announcement</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-sm-0 px-2">
                                    <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products</span></a>
                            </li>
                            <li>
                                <a href="#" class="nav-link px-sm-0 px-2">
                                    <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Customers</span>
                                </a>
                            </li>
                        </ul>
                        <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                            <a href="#"
                                class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ url('storage/images/bot-TG.jpg') }}" alt="hugenerd" width="28"
                                    height="28" class="rounded-circle">
                                <span class="d-none d-sm-inline mx-1">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                                <li><a class="dropdown-item" href="#">New project...</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col d-flex vh-100 flex-column ">
                    <main class="row overflow-auto">
                        <div class="col pt-4">

                            @yield('content')

                        </div>
                    </main>
                    <footer class="row bg-dark sticky-bottom mt-auto">
                        <!-- Copyright -->
                        <div class="text-center text-bg-dark py-3">
                            © 2023 Copyright:
                            <a class="text-info" href="https://sms-api.online/">Sms-api.online</a>
                        </div>
                        <!-- Copyright -->
                    </footer>
                </div>
            </div>
        </div>

    @endauth
    @guest
        <nav class="navbar navbar-expand-lg text-end bg-body-tertiary rounded" aria-label="Eleventh navbar example">
            <div class="container justify-content-end">
                <button class="navbar-toggler align-self-end" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsExample09" aria-controls="navbarsExample09" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExample09">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link " href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </nav>
        <main class=" position-">
            @yield('content')
        </main>
 @endguest




        <!-- ... (rest of your HTML) -->


</body>

</html>
