@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('user::labels.edit_profile')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('user::labels.edit_profile')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-8 col-md-11">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('user::labels.edit_profile')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($user, ['route' => ['aksara.user.update-profile'], 'class' => 'form-horizontal'])!!}
                    {{ method_field('PUT') }}
                        @include('user::user._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
