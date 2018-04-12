@extends('backend-percobaan::layouts.layout-auth')

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
    
        <form class="form-horizontal" method="POST">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">{{ __('core:auth-login-register::default.email') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('core:auth-login-register::default.send-prassword-reset-link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@endsection
