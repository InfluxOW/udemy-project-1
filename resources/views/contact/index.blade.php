@extends('layouts.app')

@section('content')
<h1>Contact</h1>
<p>Here will be the contacts!</p>

@can('contact.secret')
<p><a href="{{ route('contact.secret') }}">Details</a></p>
@endcan
@endsection
