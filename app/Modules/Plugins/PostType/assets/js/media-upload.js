jQuery( document ).ready(function(){
    jQuery('[media-uploader-button]').each(function(){
        mediaUploader.bindUpload(jQuery(this))

    })
});

var mediaUploader = {
    bindUpload : function(target){
        var targetPreview = jQuery(target).data('media-upload-preview');

        console.log(targetPreview)

        $jQuery(target).click(function(){

        })
    }
}
