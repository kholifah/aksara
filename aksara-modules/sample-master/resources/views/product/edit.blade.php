@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sample-product') }}">@lang('sample-master::product.labels.all_products')</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::product.labels.edit_product')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('sample-master::product.labels.edit_product')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-8 col-md-11">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('sample-master::product.labels.edit_product')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::model($product, ['route' => ['sample-product-update', $product->id], 'class' => 'form-horizontal'])!!}
                    {{ method_field('PUT') }}
                        @include('sample-master::product._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

