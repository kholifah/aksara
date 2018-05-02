@extends_backend('layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('sample-po') }}">@lang('sample-transaction::po.labels.all_po')</a></li>
    <li class="breadcrumb-item active">@lang('sample-transaction::po.labels.add_po')</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">@lang('sample-transaction::po.labels.add_po')</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-6 col-md-8">
            <div class="card-box">
                <div class="card-box__body">
                    {!! Form::open(['route' => 'sample-po-store', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        @include('sample-transaction::po._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


