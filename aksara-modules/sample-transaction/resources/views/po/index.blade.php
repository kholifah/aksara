@extends_backend('layouts.layout')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('sample-transaction::po.labels.all_po')</li>
  </ol>
@endsection

@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-transaction::po.labels.po_list')
        @if(has_capability('add-transaction-po'))
            <a href="{{ route('sample-po-create') }}" class="page-title-action">@lang('sample-transaction::po.labels.add_po')</a></h2>
        @endif
  </div>
  <!-- /.content__head -->

  {!! $table->render() !!}

@endsection


