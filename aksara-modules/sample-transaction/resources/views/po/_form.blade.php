{!! Form::hidden('id', null, ['class'=>'form-control']) !!}

<div class="form-group form-group--table {!! $errors->has('document_number') ? 'error' : '' !!}">
	<label class="col-form-label">@lang('sample-transaction::po.labels.document_number')</label>
	<div class="col-form-input">
		{!! Form::text('document_number', null, ['class'=>'form-control']) !!}
		{!! $errors->first('document_number', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group form-group--table {!! $errors->has('supplier_id') ? 'error' : '' !!}">
	<label class="col-form-label">@lang('sample-transaction::po.labels.supplier')</label>
	<div class="col-form-input">
		{!! Form::select('supplier_id', $suppliers, null, ['class'=>'form-control']) !!}
		{!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group form-group--table {!! $errors->has('order_date') ? 'error' : '' !!}">
	<label class="col-form-label">@lang('sample-transaction::po.labels.order_date')</label>
	<div class="col-form-input">
    <input style="position: relative; z-index: 100000;" readonly type="text" id="order-date-picker" class="form-control" value="{{ $po->order_date->format('d M Y') }}">
    <input name="order_date" id="order-date-field" type="hidden" value="{{ $po->order_date->format('Y-m-d') }}">
    {!! $errors->first('order_date', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="form-group form-group--table {!! $errors->has('estimated_delivery_date') ? 'error' : '' !!}">
	<label class="col-form-label">@lang('sample-transaction::po.labels.estimated_delivery_date')</label>
	<div class="col-form-input">
    <input style="position: relative; z-index: 100000;" readonly type="text" id="estimated-delivery-date-picker" class="form-control" value="{{ $po->estimated_delivery_date->format('d M Y') }}">
    <input name="estimated_delivery_date" id="estimated-delivery-date-field" type="hidden" value="{{ $po->estimated_delivery_date->format('Y-m-d') }}">
    {!! $errors->first('estimated_delivery_date', '<p class="help-block">:message</p>') !!}
	</div>
</div>

<div class="submit-row clearfix">
	@if (!$po->exists)
		{!! Form::submit(__('sample-transaction::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
	@endif
</div>
