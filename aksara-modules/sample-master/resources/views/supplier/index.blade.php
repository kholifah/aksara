@extends_backend('layouts.layout')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::supplier.labels.all_suppliers')</li>
  </ol>
@endsection

@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-master::supplier.labels.supplier_list')
      @if(has_capability('add-master-supplier'))
        <a href="{{ route('sample-supplier-create') }}" class="page-title-action">@lang('sample-master::supplier.labels.add_supplier')</a></h2>
      @endif
  </div>
  <!-- /.content__head -->

  {!! $table->render() !!}

@endsection

