@extends_backend('layouts.layout')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('aksara-user') }}">@lang('user::labels.all_user')</a></li>
    <li class="breadcrumb-item active">@lang('user::labels.edit_user')</li>
  </ol>
@endsection


@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('user::labels.edit_user')</h2>
  </div>
  <!-- /.content__head -->

  <div class="content__body">
    <div class="row">
      <div class="col-lg-8 col-md-11">
        <div class="card-box">
          <div class="card-box__header">
            <h2>@lang('user::labels.edit_user')</h2>
          </div>
          <div class="card-box__body">
            {!! Form::model($user, ['route' => ['aksara-user-update', $user->id], 'class' => 'form-horizontal'])!!}
            {{ method_field('PUT') }}
            @include('user::user._form')
            {!! Form::close() !!}
          </div>
        </div>
        @if(has_capability('add-user-role'))
          <div class="card-box">
            <div class="card-box__header">
              <h2>@lang('user::labels.add_user_role')</h2>
            </div>
            <div class="card-box__body">
              {!! Form::open([
                'route' => [ 'aksara-user-add-role', $user->id ],
                'role' => 'form',
                'class' => 'form-horizontal'
              ]) !!}
              <div class="form-group form-group--table {!! $errors->has('role_id') ? 'error' : '' !!}">
                <label class="col-form-label">@lang('user::labels.role_name')</label>
                <div class="col-form-input">
                  {!! Form::select('role_id', $select_role, null, ['class'=>'form-control']) !!}
                  {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
                </div>
              </div>
              <div class="submit-row clearfix">
                {!! Form::submit(__('user::labels.add_user_role'), ['class'=>'btn btn-md btn-primary alignright']) !!}
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        @endif
        <div class="card-box">
          <div class="card-box__header">
            <h2>@lang('user::labels.role_list')</h2>
          </div>
          <div class="card-box__body">
            {!! $table->render() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
