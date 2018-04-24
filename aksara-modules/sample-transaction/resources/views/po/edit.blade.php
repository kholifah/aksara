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
        <div class="col-lg-8 col-md-11">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('sample-transaction::po.labels.edit_po')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($po, ['route' => ['sample-po-update', $po->id], 'class' => 'form-horizontal'])!!}
                    {{ method_field('PUT') }}
                        @include('sample-transaction::po._form')
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('sample-transaction::po.labels.items')</h2>
                </div>
                <div class="card-box__body">
                  {!! Form::open([ 'route' => [ 'sample-po-store-item', $po->id ], 'role' => 'form', 'class' => 'form-horizontal' ]) !!}
                  <div class="form-group form-group--table {!! $errors->has('product_id') ? 'error' : '' !!}">
                    <label class="col-form-label">@lang('sample-transaction::po.labels.product')</label>
                    <div class="col-form-input">
                      {!! Form::select('product_id', $products, null, ['class'=>'form-control']) !!}
                      {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                  <div class="form-group form-group--table {!! $errors->has('qty') ? 'error' : '' !!}">
                    <label class="col-form-label">@lang('sample-transaction::po.labels.qty')</label>
                    <div class="col-form-input">
                      {!! Form::number('qty', 0, ['class'=>'form-control']) !!}
                      {!! $errors->first('qty', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>

                  <div class="form-group form-group--table {!! $errors->has('discount') ? 'error' : '' !!}">
                    <label class="col-form-label">@lang('sample-transaction::po.labels.discount')</label>
                    <div class="col-form-input">
                      {!! Form::number('discount', 0, ['class'=>'form-control']) !!}
                      {!! $errors->first('discount', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <div class="submit-row clearfix">
                    {!! Form::submit(__('sample-transaction::po.labels.add_item'), ['class'=>'btn btn-md btn-primary alignright']) !!}
                  </div>

                  <div class="form-group form-group--table">
                    <label class="col-form-label">@lang('sample-transaction::po.labels.total_amount')</label>
                    <div class="col-form-input">
                      {{ $po->total_amount }}
                    </div>
                  </div>

                  {!! Form::close() !!}
                </div>
                <div class="card-box__body">
                  {!! $table->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


