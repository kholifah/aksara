@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{ __('core:dashboard::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('core:module-manager::default.module-manager') }}</li>
</ol>
@endsection

@section('content')

<div class="container">
    <div class="content__head">
        <h2 class="page-title">{{ __('core:module-manager::default.module-manager') }}</h2>
    </div>
    <!-- /.content__head -->
    <div>
        <p>Plugin {!! $activatedModule['moduleName'] !!} berhasil diaktifkan</p>
        <a href="{!! url(route('module-manager.index')) !!}">Kembali ke layar module manager</a>
    <div>

    <!-- /.content__body -->
</div>

@endsection
