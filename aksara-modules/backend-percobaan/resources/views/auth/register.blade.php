@extends('backend-percobaan::layouts.layout-auth')

@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="{{ route('home') }}">Admin</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new membership</p>

    <form action="{{ route('doRegister') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <input type="text" name="name" class="form-control" placeholder="Name">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
        <input type="email" name="email" class="form-control" placeholder="Email">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
        <input type="password" name="password" class="form-control" placeholder="Password">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('password_confirmation') ? 'has-error' : '' !!}">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password">
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>


    <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->
@endsection
