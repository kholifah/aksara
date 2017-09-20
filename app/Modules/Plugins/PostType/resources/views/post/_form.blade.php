<div class="container-content">
    <div class="post-box title-field">
        <div class="title-field-wrap">
            {!! Form::text('post_title', $post->post_title, ['class'=>'form-control', 'placeholder' => 'Judul '.get_current_post_type_args('label.name') ]) !!}
            {!! Form::hidden('post_type', 'post', []) !!}
        </div>
        @if($post->id)
            <div class="edit-slug-box">
                <strong>Permalink:</strong>
                <span class="sample-permalink">
                    <a href="{{ url('/') }}/{{ get_current_post_type() }}/{{ $post->post_slug }}">
                        {{ url('/') }}/{{ get_current_post_type() }}/<span id="editable-post-name">{{ $post->post_slug }}</span>
                    </a>
                <input name="post_slug" type="text" autocomplete="off" value="{{ $post->post_slug }}" id="new-post-slug">
                </span>
                ‎<span id="edit-slug-buttons">
                    <button type="button" class="edit-slug btn btn-secondary">Edit</button>
                </span>
            </div>
        @else
            <div class="slug-wrap clearfix">
                <label>Slug</label>
                {!! Form::text('post_slug', '', ['class'=>'form-control', 'placeholder' => 'Slug']) !!}
            </div>
        @endif
    </div>
    @action('aksara.post_editor.'.get_current_post_type().'.after_title',$post)
    <div class="post-box">
        {!! Form::textarea('post_content', $post->post_content, ['id' => 'texteditor', 'class'=> 'form-control', 'rows' => '7', 'cols' => '50']) !!}
    </div>
    @action('aksara.post_editor.'.get_current_post_type().'.after_editor',$post)
</div>
<div class="container-sidebar">
    <div class="card-box post-box">
        <div class="card-box__header">
            <h2>Terbitkan</h2>
        </div>
        <div class="card-box__body form-horizontal">
            <div class="form-group form-group--table">
                <label class="col-form-label">Status</label>
                <div class="col-form-input">
                    {!! Form::select('post_status', status_post(), $post->post_status, array('class' => 'form-control form-sm')); !!}
                </div>
            </div>
        </div>
        <div class="card-box__footer">
            <div class="submit-row clearfix">
                <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan">
            </div>
        </div>
    </div>
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
                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                @endif

                <p class="info-error">type file yang anda pilih salah</p>
                <label class="form-file-wrapper btn btn-secondary">
                    Set Foto Utama
                    <input class="file" type="file" name="post_image">
                </label>
            </div>
        </div>
        @action('aksara.post_editor.'.get_current_post_type().'.sidebar',$post)
    </div>
    <?php
    $taxonomies = (\Config::get('aksara.taxonomy'));
    ?>
    @if($taxonomies)
    @foreach($taxonomies as $key => $val)
    @if($key == get_current_post_type())
    @foreach($val as $key1 => $val1)
    <div class="card-box post-box">
        <div class="card-box__header">
            <h2>{{ $val1['label']['name'] }}</h2>
        </div>
        <div class="card-box__body category-wrap">
            <ul class="unstyle-list js-scroll">
                <?php
                $term = get_term($key1);
                $post_term = get_post_term($post->id, $key1, ['order_by' => 'name']);

                $all_post_term = [];
                if($post_term)
                {
                    foreach ($post_term as $v) {
                        $all_post_term[] = $v->term_id;
                    }
                }
                ?>
                @if($term)
                @foreach ($term as $v)
                <li>
                    <div class="checkbox checkbox-inline">
                        <input value="{{ $v->id }}" name="taxonomy[{{ $key1 }}][]" type="checkbox" @if(in_array($v->id, $all_post_term)) checked @endif >
                        <label for="berita">{{ $v->name }}</label>
                    </div>
                </li>
                @endforeach
                @endif

            </ul>
        </div>
    </div>
    @endforeach
    @endif
    @endforeach
    @endif
</div>

<script >
    function delete_img(id)
    {
        $.getJSON(aksara_url + '/admin/post/' + id + '/delete_img', function(item) {
           if(!item)
               alert('Delete Fail!');
        });
    }

</script>
@section('add-footer')
<script src="{{ asset('assets/admin/assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        if ($("#texteditor").length > 0) {
            tinymce.init({
                selector: "textarea#texteditor",
                theme: "modern",
                height: 300,
                menubar: false,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | code",
                style_formats: [
                    {title: 'Header 1', format: 'h1'},
                    {title: 'Header 2', format: 'h2'},
                    {title: 'Header 3', format: 'h3'},
                    {title: 'Header 4', format: 'h4'},
                    {title: 'Header 5', format: 'h5'},
                    {title: 'Header 6', format: 'h6'},
                    {title: 'Code', icon: 'code', format: 'code'}
                ]
            });
        }
    });
</script>
@endsection
