<div class="card-box post-box">
    <div class="card-box__header">
        <h2>Foto Utama</h2>
    </div>
    <div class="card-box__body">
        <div class="form-img clearfix">
            @if ($post->post_image)
                <div class="image-preview" style="display:block">
                    <a onclick="delete_img({{ $post->id }})" class="img-remove"><i class="ti-trash"></i></a>
                    <img class="previewing" src="{{ url('/img/'.$post->post_image) }}">
                </div>
                <p class="info" style="display:block">Klik icon pada gambar untuk menghapus</p>
            @else
                <div class="image-preview">
                    <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                    <img class="previewing" src="">
                </div>
                <p class="info" media-uploader >Klik icon pada gambar untuk menghapus</p>
            @endif


            <a href="#" class="btn btn-md btn-primary alignright" media-uploader-button data-media-upload-preview="image-preview">Set Foto Utama</a>

        </div>
    </div>

    <div class="card-box__body">
        <div class="form-img clearfix">
            @if ($post->post_image)
                <div class="image-preview" style="display:block">
                    <a onclick="delete_img({{ $post->id }})" class="img-remove"><i class="ti-trash"></i></a>
                    <img class="previewing" src="{{ url('/img/'.$post->post_image) }}">
                </div>
                <p class="info" style="display:block">Klik icon pada gambar untuk menghapus</p>
            @else
                <div class="image-preview-2">
                    <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                    <img class="previewing" src="">
                </div>
                <p class="info" media-uploader >Klik icon pada gambar untuk menghapus</p>
            @endif


            <a href="#" class="btn btn-md btn-primary alignright" media-uploader-button data-media-upload-preview="image-preview-2" >Set Foto Utama</a>

        </div>
    </div>
</div>
