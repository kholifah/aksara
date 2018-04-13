@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sample-store') }}">@lang('sample-master::store.labels.all_stores')</a></li>
    <li class="breadcrumb-item active">@lang('sample-master::store.labels.add_store')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('sample-master::store.labels.add_store')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>@lang('sample-master::store.labels.add_store')</h2>
                </div>
                <div class="card-box__body">
                    {!! Form::open(['route' => 'sample-store-store', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        @include('sample-master::store._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

