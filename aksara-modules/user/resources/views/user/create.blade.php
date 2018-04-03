@extends('aksara-backend::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('aksara-user') }}">@lang('user::labels.all_user')</a></li>
    <li class="breadcrumb-item active">@lang('user::labels.add_user')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('user::labels.add_user')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('user::labels.add_user')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::open(['route' => 'aksara-user-store', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        @include('user::user._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
