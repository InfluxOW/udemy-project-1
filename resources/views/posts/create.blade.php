@extends('layouts.app')

@section('content')
{{ Form::model($post, ['url' => route('posts.store'), 'files' => true]) }}
    @include('posts._form')
    {{ Form::submit('Create', ['class' => 'btn btn-primary btn-block']) }}
{{ Form::close() }}
@endsection('content')
