{!! Form::hidden('id', $po->id, ['class'=>'form-control']) !!}

<div class="form-group form-group--table {!! $errors->has('document_number') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-transaction::po.labels.document_number')</label>
    <div class="col-form-input">
        {!! Form::text('document_number', $po->document_number, ['class'=>'form-control']) !!}
        {!! $errors->first('document_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<!-- TODO use Form::select and populate the data from presenter -->
<div class="form-group form-group--table {!! $errors->has('supplier_id') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-transaction::po.labels.supplier')</label>
    <div class="col-form-input">
        {!! Form::select('supplier_id', $suppliers, $po->supplier_id, ['class'=>'form-control']) !!}
        {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('order_date') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-transaction::po.labels.order_date')</label>
    <div class="col-form-input">
        {!! Form::date('order_date', $po->order_date ?? Carbon\Carbon::now(), ['class'=>'form-control']) !!}
        {!! $errors->first('order_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('estimated_delivery_date') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-transaction::po.labels.estimated_delivery_date')</label>
    <div class="col-form-input">
        {!! Form::date('estimated_delivery_date', $po->estimated_delivery_date ?? Carbon\Carbon::now(), ['class'=>'form-control']) !!}
        {!! $errors->first('estimated_delivery_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group form-group--table {!! $errors->has('is_applied') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-transaction::po.labels.applied')</label>
  <div class="col-form-input">
    {!! Form::hidden('is_applied', 0) !!}
    {!! Form::checkbox('is_applied', true, $po->is_applied) !!}
    {!! $errors->first('is_applied', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('is_void') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-transaction::po.labels.void')</label>
  <div class="col-form-input">
    {!! Form::hidden('is_void', 0) !!}
    {!! Form::checkbox('is_void', true, $po->is_void) !!}
    {!! $errors->first('is_void', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="submit-row clearfix">
  {!! Form::submit($po->exists ? __('sample-transaction::global.update') : __('sample-transaction::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>
