jQuery(document).ready(function(){
    jQuery('[data-remove]').click(function(){
        //remove
        jQuery(this).closest('.metabox').find('.image-preview img').attr('src','');
        jQuery(this).closest('.metabox').find('[name="post_meta"]').val("");
    })

    jQuery('[media-uploader-button]').click(function(){
        jQuery('#file-media-uploader').click();
    });

    $('#file-media-uploader').change(function () {

        jQuery(this).closest('.metabox').find('.image-preview img').attr('src', aksara_url+"/assets/modules-v2/post-type/images/preload.gif");
        jQuery(this).closest('.metabox').find('.image-preview').css('display','block');

        var mediaUploader = jQuery(this)

        if ( jQuery(this).val() != '') {
            aksaraUploader.upload("#file-media-uploader",{
                successCallback: function(data){
                    mediaUploader.closest('.metabox').find('.image-preview img').attr('src', data.image_path);
                    mediaUploader.closest('.metabox').find('[name="post_thumbnail"]').val(data.post_id);
                },
                failedCallback: function(data){
                    alert('Upload Errror');
                    mediaUploader.closest('.metabox').find('.image-preview img').attr('src', aksara_url+"/assets/modules-v2/post-type/images/default-image.png");
                    console.log(data);
                },
                errorCallback: function(data){
                    alert('Upload Error');
                    mediaUploader.closest('.metabox').find('.image-preview img').attr('src', aksara_url+"/assets/modules-v2/post-type/images/default-image.png");
                    console.log(data);
                }
            })
        }
    });
})
