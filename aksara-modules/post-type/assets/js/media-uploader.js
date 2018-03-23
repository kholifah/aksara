var filename = '';

var aksaraUploader = (function ( $ ) {
    "use strict";
    // This is the easiest way to have default options.
    // var settings = $.extend({
    //
    // }, options );

    // Greenify the collection based on the settings variable.
    var expose = {
        upload: function(target,options){

            // This is the easiest way to have default options.
            var callback = $.extend({
                successCallback:false,
                errorCallback:false,
                failedCallback:false,
            }, options );

            var file_data = $(target).prop('files')[0];

            if ($.inArray(file_data.type, [
                "image/jpeg",
                "image/png",
                "image/gif",
                "image/webp"
            ]) < 0) {
                callback.failedCallback("Image format not supported. Please choose jpeg, png, gif, or webp format image.");
                return false;
            }

            var form_data = new FormData();
            form_data.append('file', file_data);

            $.ajaxSetup({
                headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
            });
            $('#img1').html('<img src="/assets/modules-v2/post-type/images/preload.gif" style="padding-top: 40%"/>');
            $.ajax({
                url: aksara_url+"/admin/media/upload", // point to server-side PHP script
                data: form_data,
                type: 'POST',
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,
                success: function (data) {
                    if (data.fail && typeof callback.failedCallback === 'function') {
                        callback.failedCallback(data);
                    }
                    else if(typeof callback.successCallback === 'function') {
                        callback.successCallback(data);
                    }
                },
                error: function (xhr, status, error) {
                    if( typeof callback.errorCallback === 'function' ) {
                        callback.errorCallback(xhr.responseText);
                    }
                }
            });
        }
    };

    return expose;
}( jQuery ));
