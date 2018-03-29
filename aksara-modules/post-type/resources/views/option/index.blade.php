@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{__('post-type::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{__('post-type::default.option') }}</li>
</ol>
@endsection



@section('content')
    <script>
    jQuery(document).ready(function(){
        jQuery(".code-mirror").each(function(index, elem) {
            var that = $(this);
            var cm = CodeMirror.fromTextArea(elem, {
                textWrapping: true,
                lineNumbers: true,
                styleActiveLine: true,
                matchBrackets: true,
                theme: "ambiance"
            });

            setTimeout(function() {
                cm.refresh();
            }, 100);

            $(window).on("toggleShowMore", function() {
                cm.refresh();
            });

            if($(this).closest(".repeatable-base").length) {
                cm.toTextArea();
            }
        });
    })

    </script>
<div class="container">
    <div class="content__head">
        <h2 class="page-title">{{ __('post-type::default.web-option') }}</h2>
    </div>
    <!-- /.content__head -->

    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <div class="card-box col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="opsi-homepage">
                        {!! Form::open(['route' => 'aksara-post-type-option-save', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        <div class="tab-pane__body">
                            <h2 class="border-title">{{ __('post-type::default.general-settings') }}</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.main-page') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::select('options[front_page]', $pages, @$options['front_page'], ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <h2 class="border-title">{{ __('post-type::default.permalink') }}</h2>
                            <div class="form-group row">
                                <p>{{ __('post-type::message.permalink-options-message') }}</p>
                                <table class='table table-bordered table-striped'>
                                    <tr>
                                        <td>{post-type}/{slug}</td>
                                        <td>{{ __('post-type::message.default-permalink-message') }}</td>
                                    </tr>
                                    <tr>
                                        <td>{year}/{month}/{slug}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{taxonomy-name[name]}/{term-name}/{slug}</td>
                                        <td>{{ __('post-type::message.replace-taxonomy-name-message', ['name' => __('post-type::default.name')]) }}</td>
                                    </tr>
                                    <tr>
                                        <td>{slug}</td>
                                        <td>{{ __('post-type::message.default-posttype-message') }}</td>
                                    </tr>
                                </table>
                            </div>
                            @foreach ($postTypes as $postType => $args)
                            @if( get_post_type_args('publicly_queryable',$postType) )
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ get_post_type_args('label.name',$postType) }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text("options[permalink][{$postType}]",get_post_permalink_format($postType), ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <h2 class="border-title">{{ __('post-type::default.seo') }}</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.custom-meta-header') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[custom_meta_header]', @$options['custom_meta_header'], ['class'=>'form-control code-mirror','rows'=>3]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.default-site-description') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[default_site_description]', @$options['default_site_description'], ['class'=>'form-control','rows'=>2]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.robots-txt') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::select('options[robots_txt]',[true => __('post-type::default.true-index-robot'), false => __('post-type::default.false-index-robot')] ,@$options['robots_txt'], ['class'=>'form-control']) !!}
                                    <span style="font-size:12px">{{ __('post-type::message.custom-robot-txt-message') }}</span>
                                </div>
                            </div>
                            <h2 class="border-title">{{ __('post-type::default.custom-script-css') }}</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.header-script') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[header_script]', @$options['header_script'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.header-css') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[header_css]', @$options['header_css'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.footer-script') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[footer_script]', @$options['footer_script'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ __('post-type::default.footer-css') }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[footer_css]', @$options['footer_css'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane__footer">
                            <div class="submit-row clearfix">
                                <input class="btn btn-md btn-primary alignright" value="{{ __('post-type::default.save') }}" type="submit">
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
