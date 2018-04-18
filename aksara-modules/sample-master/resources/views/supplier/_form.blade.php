<div class="form-group form-group--table {!! $errors->has('supplier_name') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::supplier.labels.name')</label>
  <div class="col-form-input">
    {!! Form::text('supplier_name', $supplier->supplier_name, ['class'=>'form-control']) !!}
    {!! Form::hidden('id', $supplier->id, ['class'=>'form-control']) !!}
    {!! $errors->first('supplier_name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('supplier_phone') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::supplier.labels.phone')</label>
  <div class="col-form-input">
    {!! Form::text('supplier_phone', $supplier->supplier_phone, ['class'=>'form-control']) !!}
    {!! $errors->first('supplier_phone', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('supplier_address') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::supplier.labels.address')</label>
  <div class="col-form-input">
    {!! Form::text('supplier_address', $supplier->supplier_address, ['class'=>'form-control']) !!}
    {!! $errors->first('supplier_address', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('is_active') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::supplier.labels.active')</label>
  <div class="col-form-input">
    {!! Form::hidden('is_active', 0) !!}
    {!! Form::checkbox('is_active', true, $supplier->is_active) !!}
    {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="submit-row clearfix">
  {!! Form::submit($supplier->exists ? __('sample-master::global.update') : __('sample-master::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>
