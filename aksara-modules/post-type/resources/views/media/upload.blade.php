@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.'.get_current_post_type_args('route').'.index') }}">{{ __('post-type::default.all-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</a></li>
    <li class="breadcrumb-item active">{{ __('post-type::default.edit-post-type', ['post-type' => get_current_post_type_args('label.name')]) }}</li>
</ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <center>
                <br/>
                <div style="width:200px;height: 200px;border: 1px solid whitesmoke;text-align: center" id="img1">
                    <img width="100%" height="100%" src="{{url('assets/modules-v2/post-type/images/default-image.png')}}"/>
                </div>
                <br/>
                <p>
                    <a class='btn btn-primary file-upload' style="text-decoration: none;"><i class="glyphicon glyphicon-edit"></i>{{ __('post-type::default.upload') }}</a>&nbsp;&nbsp;
                </p>
                <input type="file" id="file1" style="display: none"/>
            </center>
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection

<?php

\Eventy::addAction('aksara.admin.footer',function(){
    ?>
    <script>
    jQuery(document).ready(function(){
        jQuery('a.file-upload').click(function(){
            jQuery('#file1').click();
        })

        $('#file1').change(function () {

            $("#img1").html('<img width="100%" height="100%" src="' + aksara_url + '/assets/modules-v2/post-type/images/preload.gif"/>')

            if ( jQuery(this).val() != '') {
                aksaraUploader.upload("#file1",{
                    successCallback: function(data){
                        $('#img1').html('<img width="100%" height="100%" src="' + data.image_path + '"/>');
                    },
                    failedCallback: function(data){
                        alert('upload error');
                        $('#img1').html('<img width="100%" height="100%" src="/assets/modules-v2/post-type/images/default-image.png"/>');
                        console.log(data);
                    },
                    errorCallback: function(data){
                        alert('upload error');
                        $('#img1').html('<img width="100%" height="100%" src="/assets/modules-v2/post-type/images/default-image.png"/>');
                        console.log(data);
                    }
                })
            }
        });
    })
    </script>
    <?php
})
?>
