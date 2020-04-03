@extends('layouts.app')

@section('content')
<x-errors/>
{{ Form::model($user, ['url' => route('users.update', compact('user')), 'files' => true, 'method' => 'PATCH']) }}
    <div class="text-center">
        <div class="text-center">
            <div class="form-group my-0">
                {{ Form::label('name', 'Name:') }}<br>
                {{ Form::text('name', "$user->name", ['class' => 'form-control']) }}<br>
            </div>
            <img src="{{ isset($user->image) ? $user->image->url() : '../../storage/avatars/default.jpg' }}" class="img-thumbnail avatar">

            <div class="card mt-4">
                <div class="card-body">
                    <h6>Upload photo</h6>
                    {{ Form::file('avatar', ['class' => 'form-control-file']) }}
                </div>
            </div>
            <br>
            <div class="form-group">
                {{ Form::submit('Save changes', ['class' => 'btn btn-primary btn-block']) }}
            </div>
        </div>
    </div>
@endsection('content')
