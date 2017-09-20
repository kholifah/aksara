@extends('admin:aksara::layouts.admin')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Menu</li>
</ol>
@endsection

@section('content')
<div class="content__head">
    <h2 class="page-title">Menu</h2>
</div>
<!-- /.content__head -->

<div class="content__body page-slider">
      <div class="card-box col-md-10">
          Harap registrasi menu dengan perintah `register_menu`
      </div>
</div>

@endsection
