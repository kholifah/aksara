@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Module Manager</li>
</ol>
@endsection

@section('content')

<div class="container">
    <div class="content__head">
        <h2 class="page-title">Module Manager</h2>
    </div>
    <!-- /.content__head -->
    <div>
        <p>Plugin {!! $activatedModule['moduleName'] !!} berhasil diaktifkan</p>
        <a href="{!! url(route('module-manager.index')) !!}">Kembali ke layar module manager</a>
    <div>

    <!-- /.content__body -->
</div>

@endsection
