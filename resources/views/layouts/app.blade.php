<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Udemy Project Site</title>
  </head>
<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Udemy Project</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="{{ route('home') }}">{{ __('Home') }}</a>
            <a class="p-2 text-dark" href="{{ route('contact') }}">{{ __('Contact') }}</a>
            <a class="p-2 text-dark" href="{{ route('posts.index') }}">{{ __('Blog Posts') }}</a>
            <a class="p-2 text-dark" href="{{ route('posts.create') }}">{{ __('Add') }}</a>

            @guest
                <a class="p-2 text-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
                <a class="p-2 text-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
                <a class="p-2 text-dark" href="{{ route('users.show', ['user' => Auth::user()]) }}">
                    {{ __('Profile') }}
                </a>
                <a class="p-2 text-dark" href="{{ route('users.edit', ['user' => Auth::user()]) }}">
                    {{ __('Edit profile') }}
                </a>
                <a class="p-2 text-dark" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                >{{ __('Logout') }} ({{ Auth::user()->name }})</a>
                {{Form::open(['url' => route('logout'), 'method' => 'POST', 'id' => 'logout-form', 'class' => 'invisible'])}}
                {{Form::close()}}
            @endguest
        </nav>
    </div>
<div class="container px-5">
    @include('flash::message')

    @yield('content')
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
