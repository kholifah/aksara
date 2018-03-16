@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ __('plugin:post-type::default.all-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</a></li>
    <li class="breadcrumb-item active">{{ __('plugin:post-type::default.edit-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</li>
</ol>
@endsection


@section('content')
<div class="content__head m-b-20">
    <h2 class="page-title">{{ __('plugin:post-type::default.edit-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</h2>
</div>
<!-- /.content__head -->
<div class="content__body column-2">
    {!! Form::open(['route' => ['admin.'.get_current_post_type_args('route').'.update', $post->id],'role' => 'form','files' => 'true'])!!}
    {{ method_field('PUT') }}
    @include('plugin:post-type::post._form')
    {!! Form::close() !!}
</div>

@endsection
