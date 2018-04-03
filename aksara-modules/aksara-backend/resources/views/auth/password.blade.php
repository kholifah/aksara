@extends('aksara-backend::layouts.layout-auth')

@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="{{ route('home') }}">Admin</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Forgot Password</p>

    <form action="{{ url('password/email') }}" method="post">
      {{ csrf_field() }}
      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
        <input type="text" name="email" class="form-control" placeholder="Email">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Send</button>
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
