@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.index') }}">{{ get_current_taxonomy_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">Edit {{ get_current_taxonomy_args('label.name') }}</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">Edit {{ get_current_taxonomy_args('label.name') }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>Edit {{ get_current_taxonomy_args('label.name') }}</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($term, ['route' => ['admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.update', $term->id], 'class' => 'form-horizontal'])!!}
                    @include('plugin:post-type::taxonomy._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
