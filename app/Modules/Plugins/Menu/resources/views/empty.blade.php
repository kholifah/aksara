@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{ __('plugin:menu::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('plugin:menu::default.menu') }}</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">{{ __('plugin:menu::default.menu') }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body page-slider">
      <div class="card-box col-md-10">
          {{ __('plugin:menu::message.register-register-menu') }}
      </div>
</div>

@endsection
