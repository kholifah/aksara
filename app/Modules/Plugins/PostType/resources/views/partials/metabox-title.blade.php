<div class="post-box title-field">
    <div class="title-field-wrap">
        {!! Form::text('post_title', $post->post_title, ['class'=>'form-control', 'placeholder' => 'Judul '.get_current_post_type_args('label.name') ]) !!}
    </div>
    @if($post->id)
        <div class="edit-slug-box">
            <strong>Permalink:</strong>
            <span class="sample-permalink">
                {{-- @todo --}}
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
