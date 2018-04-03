@extends('aksara-backend::layouts.layout-auth')

@section('content')

<div class="register-box">
  <div class="register-logo">
    <a href="{{ route('home') }}">Admin</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Set New Password</p>

    <form action="{{ url('/password/reset') }}" method="post">
      {{ csrf_field() }}
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class'=>'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
        {!! Form::label('password', 'New Password') !!}
        {!! Form::password('password', ['class'=>'form-control']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
        {!! Form::label('password_confirmation', 'Confirmation Password') !!}
        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">SET</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


    <a href="{{ route('login') }}" class="text-center">I Remember my password</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

@endsection
