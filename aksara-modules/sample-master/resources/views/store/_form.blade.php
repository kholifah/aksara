<div class="form-group form-group--table {!! $errors->has('store_name') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.labels.name')</label>
    <div class="col-form-input">
        {!! Form::text('store_name', $store->store_name, ['class'=>'form-control']) !!}
        {!! Form::hidden('id', $store->id, ['class'=>'form-control']) !!}
        {!! $errors->first('store_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('store_phone') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.labels.phone')</label>
    <div class="col-form-input">
        {!! Form::text('store_phone', $store->store_phone, ['class'=>'form-control']) !!}
        {!! $errors->first('store_phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('store_address') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-master::store.labels.address')</label>
    <div class="col-form-input">
        {!! Form::text('store_address', $store->store_address, ['class'=>'form-control']) !!}
        {!! $errors->first('store_address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="submit-row clearfix">
  {!! Form::submit($store->exists ? __('sample-master::global.update') : __('sample-master::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>
