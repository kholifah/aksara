<div class="form-group form-group--table {!! $errors->has('supplier_id') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.supplier')</label>
  <div class="col-form-input">
    {!! Form::select('supplier_id', $suppliers, $product->supplier_id, ['class'=>'form-control']) !!}
    {!! $errors->first('supplier_id', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('name') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.name')</label>
  <div class="col-form-input">
    {!! Form::text('name', $product->name, ['class'=>'form-control']) !!}
    {!! Form::hidden('id', $product->id, ['class'=>'form-control']) !!}
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('code') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.code')</label>
  <div class="col-form-input">
    {!! Form::text('code', $product->code, ['class'=>'form-control']) !!}
    {!! $errors->first('code', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('stock') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.stock')</label>
  <div class="col-form-input">
    {!! Form::number('stock', $product->stock, ['class'=>'form-control']) !!}
    {!! $errors->first('stock', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('price') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.price')</label>
  <div class="col-form-input">
    {!! Form::number('price', $product->price, ['class'=>'form-control']) !!}
    {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('date_product') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.date_product')</label>
  <div class="col-form-input">
    {!! HtmlInput::date('date_product', $product->date_product ?? Carbon\Carbon::now(), ['class'=>'form-control']) !!}
    {!! $errors->first('date_product', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="form-group form-group--table {!! $errors->has('date_expired') ? 'error' : '' !!}">
  <label class="col-form-label">@lang('sample-master::product.labels.date_expired')</label>
  <div class="col-form-input">
    {!! HtmlInput::date('date_expired', $product->date_expired ?? Carbon\Carbon::now(), ['class'=>'form-control']) !!}
    {!! $errors->first('date_expired', '<p class="help-block">:message</p>') !!}
  </div>
</div>

<div class="submit-row clearfix">
  {!! Form::submit($product->exists ? __('sample-master::global.update') : __('sample-master::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
</div>
