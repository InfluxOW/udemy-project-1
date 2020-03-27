@extends('layouts.app')

@section('content')
{{ Form::model($post, ['url' => route('posts.update', $post), 'method' => 'PATCH']) }}
    @include('posts._form')
    {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection('content')
