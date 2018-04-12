@extends('aksara-backend::layouts.layout-auth')

@section('content')

<div class="login-box" style="width:30%">
    <div class="login-logo">
        <a href="#">{{ __('core:auth-login-register::default.reset-password') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">        
        @if(session('message'))
            <p class="login-box-msg"><b>{{ session('message') }}</b></p>
        @endif
    
        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">{{ __('core:auth-login-register::default.email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">{{ __('core:auth-login-register::default.password') }}</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-4 control-label">{{ __('core:auth-login-register::default.password-confirmation') }}</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('core:auth-login-register::default.reset-password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
