<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Метод помидора">
    <meta name="keywords" content="метод помидора, pomodoro, продуктивность">
    <title>@yield('title', config('app.name'))</title>

    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/applayout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    @stack('head_css')
</head>
<body>
    <div class="wrapper">
        <div class="header-and-content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <i class="fa fa-history"></i>
                        <span>@lang('applayout.BrandName')</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('settings') }}">
                                    <i class="fa fa-cog"></i>
                                    <span>@lang('applayout.Settings')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('history') }}">
                                    <i class="fa fa-check"></i>
                                    <span>@lang('applayout.History')</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('comments') }}">
                                    <i class="fa fa-comment"></i>
                                    <span>@lang('applayout.Comments')</span>
                                </a>
                            </li>
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdownQuest" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-sign-in"></i>
                                        <span>@lang('applayout.Enter')</span>
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownQuest">
                                        <a class="dropdown-item" href="{{ route('login') }}">@lang('applayout.LoginViaEmail')</a>
                                        <a class="dropdown-item" href="{{ route('loginViaProvider', ['vkontakte']) }}">@lang('applayout.LoginViaVk')</a>
                                        <a class="dropdown-item" href="{{ route('loginViaProvider', ['google']) }}">@lang('applayout.LoginViaGoogle')</a>
                                        <a class="dropdown-item" href="{{ route('register') }}">@lang('applayout.Register')</a>
                                    </div>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fa fa-user"></i>
                                        <span>{{ Auth::user()->name ?:  Auth::user()->email }}</span>
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                        >
                                            @lang('applayout.Logout')
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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

        <!-- Footer -->
        <footer class="page-footer font-small blue pt-4 bg-white">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-2 col-sm-1"></div>
                    <div class="col-md-4 col-sm-5 mb-md-0 mb-3">
                        <h5>@lang('applayout.TermsOfUse')</h5>
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('legal-rules') }}">@lang('applayout.UserAgreement')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 col-sm-5 mb-md-0 mb-3">
                        <h5>@lang('applayout.Contacts')</h5>
                        <ul class="list-unstyled">
                            <li>
                                @lang('applayout.Email'): <a href="mailto:{{ env('MAIL_OWNER') }}">{{ env('MAIL_OWNER') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 col-sm-1"></div>
                </div>
            </div>
            <div class="footer-copyright text-center py-3">
                <div>
                    The Pomodoro Technique® by Francesco Cirillo.
                </div>
                <div>
                    &copy; {{ date("Y") }}
                    <a href="/"> {{ env('DOMAIN') }}</a>.
                    @lang('applayout.Copyright')
                </div>
            </div>
        </footer>

    </div>

    <script>
        window.transMessages = {};
    </script>
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/bootstrap.js') }}"></script>
    @stack('body_scripts')
</body>
</html>
