@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Option</li>
</ol>
@endsection

@section('content')
<div class="container">
    <div class="content__head">
        <h2 class="page-title">Site Option</h2>
    </div>
    <!-- /.content__head -->

    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <ul class="nav nav-pills nav-stacked col-md-2">
                <li class="active">
                    <a href="#opsi-homepage" data-toggle="pill">Opsi Umum</a>
                </li>
                <li>
                    <a href="#opsi-kontakform" data-toggle="pill">Opsi Kontak Form</a>
                </li>
            </ul>
            <div class="card-box col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="opsi-homepage">
                        {!! Form::open(['route' => 'aksara-option-save', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        <div class="tab-pane__body">
                            <h2 class="border-title">Opsi Umum</h2>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Nama Aplikasi</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[application_name]', @$site_options['application_name'], ['class'=>'form-control', 'placeholder' => 'Judul Website']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Website</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[site_title]', @$site_options['site_title'], ['class'=>'form-control', 'placeholder' => 'Judul Website']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul Website (Admin)</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[admin_site_title]', @$site_options['admin_site_title'], ['class'=>'form-control', 'placeholder' => 'Judul Website']) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Tagline</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[tagline]', @$site_options['tagline'], ['class'=>'form-control', 'placeholder' => 'Tagline Website']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane__footer">
                            <div class="submit-row clearfix">
                                <input class="btn btn-md btn-primary alignright" value="Simpan Pengaturan" type="submit">
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                    <div class="tab-pane" id="opsi-kontakform">
                        <form action="">
                            <div class="tab-pane__body repeat-wrap">
                                <h2>Kontak Form</h2>
                                <div class="tag-generator">
                                    <button class="btn btn-secondary" data-type="text">text</button>
                                    <button class="btn btn-secondary" data-type="email">email</button>
                                    <button class="btn btn-secondary" data-type="url">URL</button>
                                    <button class="btn btn-secondary" data-type="tel">tel</button>
                                    <button class="btn btn-secondary" data-type="number">number</button>
                                    <button class="btn btn-secondary" data-type="password">password</button>
                                    <button class="btn btn-secondary" data-type="textarea">textarea</button>
                                    <button class="btn btn-secondary" data-type="dropdown">dropdown</button>
                                    <button class="btn btn-secondary" data-type="checkbox">checkboxes</button>
                                    <button class="btn btn-secondary" data-type="radio">radio buttons</button>
                                    <button class="btn btn-secondary" data-type="file">file</button>
                                    <button class="btn btn-secondary" data-type="submit">submit</button>
                                </div>
                                <div class="form-group">
                                    <textarea id="generator-area" class="form-control" rows="20" aria-hidden="true"></textarea>
                                </div>
                            </div>

                            <div class="tab-pane__footer">
                                <div class="submit-row clearfix">
                                    <input class="btn btn-md btn-primary alignright" value="Simpan Kontak Form" type="submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- tab content -->
            </div>
        </div>
    </div>
    <!-- /.content__body -->
</div> <!-- container -->



@endsection
