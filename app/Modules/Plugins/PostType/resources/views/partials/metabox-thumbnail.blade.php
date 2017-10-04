<div class="card-box post-box">
    <div class="card-box__header">
        <h2>Foto Utama</h2>
    </div>
    <div class="card-box__body">
        <div class="form-img clearfix">
            @if (get_featured_image($post->id))
                <div class="image-preview" style="display:block">
                    <a data-tumbnail-id="({{ $post->id }})" data-remove><i class="ti-trash"></i></a>
                    <img src="{{ get_featured_image($post->id) }}">
                </div>
                <p class="info" style="display:block">Klik icon pada gambar untuk menghapus</p>
            @else
                <div class="image-preview">
                    <a data-tumbnail-id="({{ $post->id }})" href="#" data-remove ><i class="ti-trash"></i></a>
                    <img src="{{url('assets/modules/Plugins/PostType/images/default-image.png')}}">
                </div>
                <p class="info" media-uploader >Klik icon pada gambar untuk menghapus</p>
            @endif
            <input type="file" id="file-media-uploader" style="display: none"/>
            <a href="#" data-tumbnail-id="({{ $post->id }})" class="btn btn-md btn-primary alignright" media-uploader-button >Set Foto Utama</a>
            <input type="hidden" value="{{ get_featured_image($post->id) }}" name="post_thumbnail">
        </div>
    </div>
</div>
