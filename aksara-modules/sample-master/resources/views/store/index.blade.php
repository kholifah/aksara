@extends_backend('layouts.layout')
@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::store.labels.all_stores')</li>
  </ol>
@endsection

@section('content')
  <div class="content__head">
    <h2 class="page-title">@lang('sample-master::store.labels.store_list')
      <a href="{{ route('sample-store-create') }}" class="page-title-action">@lang('sample-master::store.labels.add_store')</a></h2>
  </div>
  <!-- /.content__head -->

  {!! $table->render() !!}

@endsection

