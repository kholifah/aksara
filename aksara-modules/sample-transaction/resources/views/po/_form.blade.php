{!! Form::hidden('id', $po->id, ['class'=>'form-control']) !!}

<div class="form-group form-group--table {!! $errors->has('document_number') ? 'error' : '' !!}">
    <label class="col-form-label">@lang('sample-transaction::po.labels.document_number')</label>
    <div class="col-form-input">
        {!! Form::text('document_number', $po->document_number, ['class'=>'form-control']) !!}
        {!! $errors->first('document_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

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

<div class="submit-row clearfix">
  @if (!$po->exists)
    {!! Form::submit(__('sample-transaction::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
  @endif
</div>
