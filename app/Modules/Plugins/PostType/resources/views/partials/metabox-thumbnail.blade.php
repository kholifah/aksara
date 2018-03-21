<div class="card-box post-box">
    <div class="card-box__header">
        <h2>{{ __('plugin:post-type::default.main-photo') }}</h2>
    </div>
    <div class="card-box__body">
        <div class="form-img clearfix">
            @if (get_post_featured_image($post->id))
                <div class="image-preview" style="display:block">
                    <a data-tumbnail-id="({{ $post->id }})" data-remove><i class="ti-trash"></i></a>
                    <img src="{{ get_post_featured_image($post->id) }}">
                </div>
                <p class="info" style="display:block">{{ __('plugin:post-type::message.click-image-to-delete-message') }}</p>
            @else
                <div class="image-preview">
                    <a data-tumbnail-id="({{ $post->id }})" href="#" data-remove ><i class="ti-trash"></i></a>
                    <img src="{{url('assets/modules/Plugins/PostType/images/default-image.png')}}">
                </div>
                <p class="info" media-uploader >{{ __('plugin:post-type::message.click-image-to-delete-message') }}</p>
            @endif
            <input type="file" id="file-media-uploader" style="display: none"/>
            <a href="#" data-tumbnail-id="({{ $post->id }})" class="btn btn-md btn-primary alignright" media-uploader-button >{{ __('plugin:post-type::default.set-main-photo') }}</a>
            <input type="hidden" value="{{ get_post_featured_image_id($post->id) }}" name="post_thumbnail">
        </div>
    </div>
</div>
