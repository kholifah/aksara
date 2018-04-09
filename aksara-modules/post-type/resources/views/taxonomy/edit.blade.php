@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{__('post-type::default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ get_current_post_type_args('label.name') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.index') }}">{{ get_current_taxonomy_args('label.name') }}</a></li>
    <li class="breadcrumb-item active">{{ __('post-type::default.edit-taxonomy', ['taxonomy' => get_current_taxonomy_args('label.name') ]) }}</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">{{ __('post-type::default.edit-taxonomy', ['taxonomy' => get_current_taxonomy_args('label.name') ]) }}</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>{{ __('post-type::default.edit-taxonomy', ['taxonomy' => get_current_taxonomy_args('label.name') ]) }}</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($term, ['route' => ['admin.'.get_current_post_type_args('route').'.'.get_current_taxonomy_args('slug').'.update', $term->id], 'class' => 'form-horizontal'])!!}
                    @include('post-type::taxonomy._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
