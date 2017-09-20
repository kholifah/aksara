@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}">Semua {{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">Edit {{ get_current_post_type_args('label.name') }}</li>
</ol>
@endsection


@section('content')
<div class="content__head m-b-20">
    <h2 class="page-title">Edit Post</h2>
</div>
<!-- /.content__head -->
<div class="content__body column-2">
    {!! Form::open(['route' => ['admin.'.get_current_post_type_slug().'.update', $post->id],'role' => 'form','files' => 'true'])!!}
    {{ method_field('PUT') }}
    @include('plugin:post-type::post._form')
    {!! Form::close() !!}
</div>

@endsection
