@extends('layouts.app')

@section('content')
{{Form::open(['url' => route('login'), 'method' => 'POST'])}}
    <div class="form-group col-lg mb-2 my-3">
    {{Form::label('email', __('E-mail'))}}
    {{Form::email('email', '', ['class' => $errors->has('email') ? 'form-control is-invalid' : 'form-control'])}}
    @if ($errors->has('email'))
        <span class="invalid-feedback">
            <strong>
                {{ $errors->first('email') }}
            </strong>
        </span>
    @endif
    </div>
    <div class="form-group col-lg mb-2 my-3">
    {{Form::label('password', __('Password'))}}
    {{Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control'])}}
    @if ($errors->has('password'))
        <span class="invalid-feedback">
            <strong>
                {{ $errors->first('password') }}
            </strong>
        </span>
    @endif
    </div>

    <div class="form-group col-lg mb-2 my-3">
        <div class="form-check">
            {{ Form::checkbox('remember', '', false, ['class' => 'form-check-input']) }}
            {{ Form::label('remember', __('Remember me'), ['class' => 'form-check-label']) }}
        </div>
    </div>

    <div class="form-group col-lg mb-2 my-3">
    {{Form::submit(__('Login'), ['class' => 'btn btn-primary btn-block'])}}
    </div>
{{Form::close()}}
@endsection
