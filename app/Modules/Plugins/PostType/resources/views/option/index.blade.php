@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Option</li>
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
        <h2 class="page-title">Website Option</h2>
    </div>
    <!-- /.content__head -->

    <div class="content__body page-slider">
        <div class="vertical-tabs row">
            <div class="card-box col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="opsi-homepage">
                        {!! Form::open(['route' => 'aksara-post-type-option-save', 'role' => 'form', 'class' => 'form-horizontal'])!!}
                        <div class="tab-pane__body">
                            <h2 class="border-title">Pengaturan Umum</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Halaman utama</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::select('options[front_page]', $pages, @$options['front_page'], ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <h2 class="border-title">Permalink</h2>
                            <div class="form-group row">
                                <p>Permalink Options, choose one of the options</p>
                                <table class='table table-bordered table-striped'>
                                    <tr>
                                        <td>{post-type}/{slug}</td>
                                        <td>Default permalink for custom post type</td>
                                    </tr>
                                    <tr>
                                        <td>{year}/{month}/{slug}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>{taxonomy-name[name]}/{term-name}/{slug}</td>
                                        <td>replace [name] with the taxonomy name</td>
                                    </tr>
                                    <tr>
                                        <td>{slug}</td>
                                        <td>Default for post and page</td>
                                    </tr>
                                </table>
                            </div>
                            @foreach ($postTypes as $postType => $args)
                            @if( get_post_type_args('publicly_queryable',$postType) )
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">{{ get_post_type_args('label.name',$postType) }}</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::text("options[permalink][{$postType}]",$permalink->getPostPermalinkFormat($postType), ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            @endif
                            @endforeach
                            <h2 class="border-title">SEO</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Custom meta header</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[custom_meta_header]', @$options['custom_meta_header'], ['class'=>'form-control code-mirror','rows'=>3]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Default site description</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[default_site_description]', @$options['default_site_description'], ['class'=>'form-control','rows'=>2]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Robots txt</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::select('options[robots_txt]',[true=>"Allow Search Engine to Index",false=>"Don't allow search engine to index"] ,@$options['robots_txt'], ['class'=>'form-control']) !!}
                                    <span style="font-size:12px">*For custom robots.txt please create robots.txt on 'public/robots.txt'</span>
                                </div>
                            </div>
                            <h2 class="border-title">Custom Script / CSS</h2>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Header Script</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[header_script]', @$options['header_script'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Header CSS</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[header_css]', @$options['header_css'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Footer Script</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[footer_script]', @$options['footer_script'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Footer CSS</label>
                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                    {!! Form::textArea('options[footer_css]', @$options['footer_css'], ['class'=>'form-control code-mirror','rows'=>4]) !!}
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
                </div>
                <!-- tab content -->
            </div>
        </div>
    </div>
    <!-- /.content__body -->
</div> <!-- container -->



@endsection
