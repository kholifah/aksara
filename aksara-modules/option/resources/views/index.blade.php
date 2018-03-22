@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">@lang('option::labels.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('option::labels.option')</li>
</ol>
@endsection

@section('content')
<div class="container">
    <div class="content__head">
        <h2 class="page-title">@lang('option::labels.general_option')</h2>
    </div>
    <!-- /.content__head -->

    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <div class="card-box col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="opsi-homepage">
                        {!! Form::open(['route' => 'aksara-option-save', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        <div class="tab-pane__body">
                            <h2 class="border-title">@lang('option::labels.general_option')</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('option::labels.application_name')</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[application_name]', @$site_options['application_name'], ['class'=>'form-control', 'placeholder' => __('option::labels.application_name_placeholder') ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('option::labels.website_title')</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[site_title]', @$site_options['site_title'], ['class'=>'form-control', 'placeholder' =>  __('option::labels.website_title_placeholder') ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('option::labels.admin_website_title')</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[admin_site_title]', @$site_options['admin_site_title'], ['class'=>'form-control', 'placeholder' =>  __('option::labels.admin_website_title_placeholder') ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('option::labels.tagline')</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text('options[tagline]', @$site_options['tagline'], ['class'=>'form-control', 'placeholder' =>  __('option::labels.tagline_placholder') ]) !!}
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">@lang('option::labels.language')</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::select('options[language]',$lang_options, @$site_options['language'], ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane__footer">
                            <div class="submit-row clearfix">
                                <input class="btn btn-md btn-primary alignright" value="@lang('option::labels.save')" type="submit">
                            </div>
                        </div>
                        {!! Form::close()!!}
                    </div>
                </div>
                <!-- tab content -->
            </div>
        </div>
    </div>
    <!-- /.content__body -->
</div> <!-- container -->

@endsection
