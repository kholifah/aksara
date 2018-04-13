@extends_backend('layouts.layout')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::product.labels.all_products')</li>
  </ol>
@endsection

@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-master::product.labels.product_list')
      <a href="{{ route('sample-product-create') }}" class="page-title-action">@lang('sample-master::product.labels.add_product')</a></h2>
  </div>
  <!-- /.content__head -->

  {!! $table->render() !!}

@endsection

