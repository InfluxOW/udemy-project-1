@extends('layouts.app')

@section('content')
{{ Form::model($post, ['url' => route('posts.update', $post), 'method' => 'PATCH', 'files' => true]) }}
    @include('posts._form')
    {{ Form::submit(__('Update'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection('content')
