@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sample-store') }}">@lang('sample-master::store.labels.all_stores')</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::store.labels.edit_store')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('sample-master::store.labels.edit_store')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-8 col-md-11">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('sample-master::store.title')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($store, ['route' => ['sample-store-update', $store->id], 'class' => 'form-horizontal'])!!}
                    {{ method_field('PUT') }}
                        @include('sample-master::store._form')
                    {!! Form::close() !!}
                </div>
                <div class="card-box__header">
                    <h2>@lang('sample-master::store.manager.title')</h2>
                </div>
                <div class="card-box__body">
                  @if (!$store->manager->exists)
                    {!! Form::open(['route' => [ 'sample-store-manager-store', $store->id ], 'role' => 'form', 'class' => 'form-horizontal'])!!}
                  @else
                    {!! Form::open(['route' => [ 'sample-store-manager-update', $store->id, $store->manager->id ], 'role' => 'form', 'class' => 'form-horizontal'])!!}
                  @endif
                        @include('sample-master::store.manager_form')
                  {!! Form::close() !!}
                </div>
                <div class="card-box__header">
                    <h2>@lang('sample-master::store.labels.add_product')</h2>
                </div>
                <div class="card-box__body">
                  {!! Form::open(['route' => [ 'sample-store-product-store', $store->id ], 'role' => 'form', 'class' => 'form-horizontal']) !!}
                  <div class="form-group form-group--table {!! $errors->has('product_id') ? 'error' : '' !!}">
                    <label class="col-form-label">@lang('sample-master::global.search')</label>
                    <div class="col-form-input">
                      {!! Form::select('product_id', $select_product, null, ['class'=>'form-control']) !!}
                      {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                    </div>
                  </div>
                  <div class="submit-row clearfix">
                    {!! Form::submit(__('sample-master::store.labels.add_product'), ['class'=>'btn btn-md btn-primary alignright']) !!}
                  </div>
                  {!! Form::close() !!}
                </div>
                <div class="card-box__header">
                    <h2>@lang('sample-master::product.labels.product_list')</h2>
                </div>
                <div class="card-box__body">
                  {!! $table->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

