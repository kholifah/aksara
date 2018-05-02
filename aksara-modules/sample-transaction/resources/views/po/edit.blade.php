@extends_backend('layouts.layout')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sample-po') }}">@lang('sample-transaction::po.labels.all_po')</a></li>
    <li class="breadcrumb-item active">@lang('sample-transaction::po.labels.edit_po')</li>
  </ol>
@endsection


@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-transaction::po.labels.edit_po')</h2>
  </div>
  <!-- /.content__head -->

  <div class="content__body">
    <div class="row">
      {!! Form::model($po, ['route' => ['sample-po-update', $po->id], 'class' => 'form-horizontal'])!!}
      {{ method_field('PUT') }}
      <div class="col-md-8">
        <div class="card-box">
          <div class="card-box__body">
            @include('sample-transaction::po._form')
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-box">
          <div class="card-box__header">
            <h3>@lang('sample-transaction::po.labels.status'): {{ $po->status }}</h3>
          </div>
          <div class="card-box__body">
            <div class="form-group form-group--table">
              <div class="col-form-input">
                {!! Form::select('status', [
                  'applied' => __('sample-transaction::po.labels.applied'),
                  'void' => __('sample-transaction::po.labels.void'),
                ], null, [
                  'class'=>'form-control',
                  'placeholder' => __('sample-transaction::po.labels.select_next_status'),
                ]) !!}
                {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
              </div>
            </div>
            <div class="submit-row clearfix">
              {!! Form::submit($po->exists ? __('sample-transaction::global.update') : __('sample-transaction::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
            </div>
          </div>
        </div>
      </div>
      {!! Form::close() !!}
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-box">
          <div class="card-box__header">
            <h3>@lang('sample-transaction::po.labels.add_item')</h3>
          </div>
          <div class="card-box__body">
            {!! Form::open([ 'route' => [ 'sample-po-store-item', $po->id ], 'role' => 'form', 'class' => 'form-inline' ]) !!}

            <div class="form-group form-group--table {!! $errors->has('product_id') ? 'error' : '' !!}">
              <label class="sr-only">@lang('sample-transaction::po.labels.product')</label>
              <div class="col-form-input">
                {!! Form::select('product_id', $products, null, [
                  'id' => 'select_product_id',
                  'class'=>'form-control',
                  'placeholder' => __('sample-transaction::po.labels.select_product'),
                ]) !!}
                {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group form-group--table">
              <label class="sr-only">@lang('sample-transaction::po.labels.unit_price')</label>
              <div class="col-form-input">
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  {!! Form::text('unit_price', null, [
                    'id' => 'item_unit_price',
                    'class'=> 'form-control',
                    'disabled' => true,
                  ]) !!}
                </div>
                {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group form-group--table {!! $errors->has('qty') ? 'error' : '' !!}">
              <label class="sr-only">@lang('sample-transaction::po.labels.qty')</label>
              <div class="col-form-input">
                {!! Form::number('qty', null, [
                  'id' => 'number_item_qty',
                  'class'=>'form-control',
                  'placeholder' => __('sample-transaction::po.labels.input_qty'),
                ]) !!}
                {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group form-group--table {!! $errors->has('discount') ? 'error' : '' !!}">
              <label class="sr-only">@lang('sample-transaction::po.labels.discount')</label>
              <div class="col-form-input">
                <div class="input-group">
                  {!! Form::number('discount', null, [
                    'id' => 'number_discount',
                    'class'=> 'form-control percent',
                    'placeholder' => __('sample-transaction::po.labels.input_discount'),
                    'step' => 'any',
                    'min' => 0,
                    'max' => 100
                  ]) !!}
                  <span class="input-group-addon">%</span>
                </div>
                {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group form-group--table">
              <label class="sr-only">@lang('sample-transaction::po.labels.unit_price')</label>
              <div class="col-form-input">
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  {!! Form::text('sub_total', null, [
                    'id' => 'item_sub_total',
                    'class'=> 'form-control',
                    'disabled' => true,
                  ]) !!}
                </div>
                {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::submit(__('sample-transaction::global.create'), ['class'=>'btn btn-md btn-primary alignright']) !!}
            </div>

            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card-box">
          <div class="card-box__header">
            <h3>{{ $po->items->count() }} {{ trans_choice('sample-transaction::po.labels.items', $po->items->count()) }} - @lang('sample-transaction::po.labels.total_amount') {{ number_format($po->total_amount, 2) }}</h3>
          </div>
          <div class="card-box__body">
            {!! $table->render() !!}
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


