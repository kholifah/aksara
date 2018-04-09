@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('aksara-role') }}">@lang('user::labels.all_roles')</a></li>
    <li class="breadcrumb-item active">@lang('user::labels.edit_role')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('user::labels.edit_role')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-8 col-md-11">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('user::labels.edit_role')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($role, ['route' => ['aksara-role-update', $role->id], 'class' => 'form-horizontal'])!!}
                    {{ method_field('PUT') }}
                    @include('user::role._form')
                    <div class="submit-row clearfix">
                        <input type="submit" class="btn btn-md btn-primary alignright" value="{{__('user::labels.update_role')}}">
                        <a href="{{ route('aksara-role') }}" class="btn btn-md btn-danger alignright">
                            @lang('user::labels.cancel')</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
