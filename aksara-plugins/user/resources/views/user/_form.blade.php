<div class="form-group form-group--table {!! $errors->has('name') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('user::labels.user_name')</label>
    <div class="col-form-input">
        {!! Form::text('name', $user->name, ['class'=>'form-control']) !!}
        {!! Form::hidden('id', $user->id, ['class'=>'form-control']) !!}
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('email') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('user::labels.email')</label>
    <div class="col-form-input">
        {!! Form::email('email', $user->email, ['class'=>'form-control']) !!}
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('active') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('user::labels.active')</label>
    <div class="col-form-input">
        {!! Form::select('active', [1 => 'Active', 0 => 'Non Active'], $user->active, ['class'=>'form-control']) !!}
        {!! $errors->first('active', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('password') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('user::labels.password')</label>
    <div class="col-form-input">
        {!! Form::password('password', ['class'=>'form-control']) !!}
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('password_confirmation') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('user::labels.password_confirmation')</label>
    <div class="col-form-input">
        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="submit-row clearfix">
    {!! Form::submit($user->exists ? __('user::labels.update') : __('user::labels.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>
