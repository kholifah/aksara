@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}">Semua {{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">Tambah {{ get_current_post_type_args('label.name') }}</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">Tambah {{ get_current_post_type_args('label.name') }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body column-2">
    {!! Form::open(['route' => 'admin.'.get_current_post_type_slug().'.store','role' => 'form','files' => 'true'])!!}
    @include('plugin:post-type::post._form')
    {!! Form::close() !!}
</div>

@endsection
