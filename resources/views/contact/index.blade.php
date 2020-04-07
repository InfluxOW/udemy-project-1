@extends('layouts.app')

@section('content')
<h1>{{ __('Contact') }}</h1>
<p>{{ __('Here will be the contacts!') }}</p>

@auth
    @can('contact.secret')
        <p><a href="{{ route('contact.secret') }}">{{ __('Details') }}</a></p>
    @endcan
@endauth

@endsection
