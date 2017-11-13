@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('aksara-role') }}">Role</a></li>
    <li class="breadcrumb-item active">Tambah Role</li>
</ol>
@endsection


@section('content')
<div class="content__head">
    <h2 class="page-title">Tambah Role</h2>
</div>
<!-- /.content__head -->

<div class="content__body">
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="card-box">
                <div class="card-box__header">
                    <h2>Tambah Role</h2>
                </div>
                <div class="card-box__body">                   
                    {!! Form::open(['route' => 'aksara-role-store', 'role' => 'form', 'class' => 'form-horizontal'])!!}                               
                    @include('plugin:user::role._form')   
                    <div class="submit-row clearfix">                                                   
                        <input type="submit" class="btn btn-md btn-primary alignright" value="Tambah Role">                                                     
                    </div>
                    {!! Form::close() !!}                   
                </div>                                        
            </div>
        </div>
    </div>
</div>

@endsection
