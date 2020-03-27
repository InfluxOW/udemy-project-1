@extends('layouts.app')

@section('content')
{{ Form::model($post, ['url' => route('posts.store')]) }}
    @include('posts._form')
    {{ Form::submit('Create', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection('content')
