<div class="card-box__body">
  <div class="form-group form-group--table {!! $errors->has('manager_name') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.manager.labels.name')</label>
    <div class="col-form-input">
      {!! Form::text('manager_name', $store->manager->manager_name, ['class'=>'form-control']) !!}
      {!! Form::hidden('id', $store->manager->id, ['class'=>'form-control']) !!}
      {!! $errors->first('manager_name', '<p class="help-block">:message</p>') !!}
    </div>
  </div>

  <div class="form-group form-group--table {!! $errors->has('manager_phone') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.manager.labels.phone')</label>
    <div class="col-form-input">
      {!! Form::text('manager_phone', $store->manager->manager_phone, ['class'=>'form-control']) !!}
      {!! $errors->first('manager_phone', '<p class="help-block">:message</p>') !!}
    </div>
  </div>

  <div class="form-group form-group--table {!! $errors->has('manager_address') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.manager.labels.address')</label>
    <div class="col-form-input">
      {!! Form::text('manager_address', $store->manager->manager_address, ['class'=>'form-control']) !!}
      {!! $errors->first('manager_address', '<p class="help-block">:message</p>') !!}
    </div>
  </div>
</div>

<!-- /.store manager -->

<div class="submit-row clearfix">
  {!! Form::submit($store->manager->exists ? __('sample-master::global.update') : __('sample-master::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>

