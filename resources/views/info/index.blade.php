@extends('layouts.app')

@section('content')
<h1 class="display-4">{{ __('Info') }}</h1>
<p class="lead">
    {{ __('This is my second ever made web site. It was created as a Udemy course result.') }}
    {{ __("You can find its code") }} <a href="https://github.com/InfluxOW/udemy-project-1">{{ __('here') }}</a>.
</p>

@auth
    @can('info.secret')
        <p><a href="{{ route('info.secret') }}">{{ __('Details') }}</a></p>
    @endcan
@endauth

@endsection
