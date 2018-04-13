@extends('backend-percobaan::layouts.layout-auth')

@section('content')
<div class="login-box">
  <div class="login-logo">
    <a href="#">@filter('aksara.login_page_title', 'Aksara Login')</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">@filter('aksara.login_page_tagline', 'Sign in to start your session')</p>
    @if(session('message'))
      <p class="login-box-msg"><b>{{ session('message') }}</b></p>
    @endif
    {{--

    --}}
    {!! Form::open(['route'=>'admin.doLogin']) !!}
      <div class="form-group {!! $errors->has('email') ? 'has-error' : '' !!}">
        <input type="email" name="email" class="form-control" placeholder="Email">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="form-group {!! $errors->has('password') ? 'has-error' : '' !!}">
        <input type="password" name="password" class="form-control" placeholder="Password">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="row">
        <div class="col-xs-8">
          {{--
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> {{ __('core:auth-login-register::default.remember-me') }}
              </label>
            </div>
          --}}
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('core:auth-login-register::default.login') }}</button>
        </div>
        <!-- /.col -->
      </div>
    {!!Form::close()!!}
    <div class="row">
      <div class="col-xs-12">
        @if(\Eventy::filter('aksara.enabled_reset_password', '1'))     
        <a href="{{ route('password.request') }}">  
        {{ __('core:auth-login-register::default.reset-password') }}
        </a>
        @endif
      </div>
    </div>


  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
