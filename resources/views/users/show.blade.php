@extends('layouts.app')

@section('content')
<x-errors/>
    <div class="row">
        <div class="col-8">
            <x-comment-form :route="route('users.comments.store', compact('user'))"/>
            <x-comment-list :item="$user"/>
        </div>
        <div class="col-4 text-center">
            <h3>{{ $user->name }}</h3>
            <img src="{{ isset($user->image) ? $user->image->url() : '../storage/avatars/default.jpg' }}" class="img-thumbnail avatar">
        </div>
    </div>
@endsection('content')
