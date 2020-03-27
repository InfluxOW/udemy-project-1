@extends('layouts.app')

@section('content')
{{Form::open(['url' => route('register'), 'method' => 'POST'])}}
    <div class="form-group col-lg mb-2 my-3">
    {{Form::label('name', 'Name')}}
    {{Form::text('name', '', ['class' => $errors->has('name') ? 'form-control is-invalid' : 'form-control' ])}}
    @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>
                {{ $errors->first('name') }}
            </strong>
        </span>
    @endif
    </div>
    <div class="form-group col-lg mb-2 my-3">
    {{Form::label('email', 'E-mail')}}
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
    {{Form::label('password', 'Password')}}
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
    {{Form::label('password_confirmation', 'Password Confirmation')}}
    {{Form::password('password_confirmation', ['class' => "form-control"])}}
    </div>
    <div class="form-group col-lg mb-2 my-3">
    {{Form::submit('Register', ['class' => 'btn btn-primary btn-block'])}}
    </div>
{{Form::close()}}
@endsection
