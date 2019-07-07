<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ __('project.name') }} @yield('title', ' - ExampleUrl.com')</title>
        <!-- External -->
        <link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/components/menu.min.css">
        <!-- Internal -->
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="https://www.studydrive.net/image/favicons/16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="https://www.studydrive.net/image/favicons/32x32.png" sizes="32x32">

        <meta name="apple-mobile-web-app-title" content="{{ __('project.name') }}">
        <meta name="application-name" content="{{ __('project.name') }}">
        <meta name="theme-color" content="#ffffff">
        <meta name="user-id" content="{{ optional(Auth::user())->id }}">
        <meta name="weekday" content="{{ $project }}">
    </head>
    <body>

        @section('header')
        <header>
            <div class="container">
                <a href="{{ url('/') }}"><img src="{{ asset('img/logo.svg') }}" alt="Logo" /></a>
                <div class="line"></div>

                <div class="auth">
                    <i class="material-icons">account_circle</i>
                    @auth
                        <a href="{{ url('/home') }}">{{ __('home.welcome') }}, {{ Auth::user()->name }}</a>
                         |
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        @if (!Request::is('register'))
                            <a href="{{ url('/register') }}">{{ __('home.register') }}</a> |
                        @endif
                        <a href="{{ url('/login') }}">{{ __('home.login') }}</a>
                    @endauth
                </div>

                <div class="intro">
                    <div>
                        <h2>{{ __('home.weekend_mode') }}</h2>
                        <p>{{ __('home.weekend_mode_details') }}</p>

                        @if ($project)
                            <a href="{{ url('/?weekend=1') }}">
                            <input class="btn btn-info" type="submit" name="search" value="{{ __('home.switch_weekend') }}" />
                            </a>
                        @else
                            <a href="{{ url('/?weekday=1') }}">
                            <input class="btn btn-info" type="submit" name="search" value="{{ __('home.switch_weekday') }}" />
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </header>
        @show

        <main>
            @section('main')
            @show
        </main>
        @section('footer')
            <footer>
                <div class="container">
                    &copy; {{ date('Y') }} &nbsp;&ndash;&nbsp; {{ __('project.name') }}

                    <div class="nav">
                        {!! '<a href="'.url("/imprint").'">'.__('base.imprint').'</a>' !!}
                        {!! '<a href="'.url("/privacy-policy").'">'.__('base.privacy').'</a>' !!}
                        {!! '<a href="'.url("/terms-of-service").'">'.__('base.terms_of_service').'</a>' !!}
                    </div>

                    <p class="address">
                    Studydrive GmbH<br />
                    Mehringdamm 32<br />
                    10961 Berlin, Germany
                    </p>
                </div>
            </footer>
        @show

        <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.min.js"></script>
        <script src="https://unpkg.com/vuejs-paginate@latest"></script>
        <script src="{{ asset('js/bundle.js') }}"></script>

        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
