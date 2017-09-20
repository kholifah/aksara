@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_slug().'.index') }}">{{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_slug().'.'.get_current_taxonomy_slug().'.index') }}">{{ get_current_taxonomy_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">Tambah {{ get_current_taxonomy_args('label.name') }}</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">Tambah {{ get_current_taxonomy_args('label.name') }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>Tambah {{ get_current_taxonomy_args('label.name') }}</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::open(['route' => 'admin.'.get_current_post_type_slug().'.'.get_current_taxonomy().'.store', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        @include('plugin:post-type::taxonomy._form')                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
