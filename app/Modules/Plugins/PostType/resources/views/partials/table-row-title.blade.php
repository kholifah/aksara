<td>
	{{ $post->post_title }}
	<div class="table__actions">
		@if($post->post_status == 'trash')
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.restore', $post->id) }}">{{ __('plugin:post-type::default.restore') }}</a> | </span>
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}">{{ __('plugin:post-type::default.edit') }}</a> | </span>
        <span class="delete"><a onclick="return confirm('Yakin ingin menghapus data?');" href="{{ route('admin.'.get_current_post_type_args('route').'.destroy', $post->id) }}" class="sa-warning">{{ __('plugin:post-type::default.delete') }}</a> | </span>
        <span class="view"><a target="_BLANK" href="{{ get_post_permalink($post) }}">{{ __('plugin:post-type::default.view') }}</a></span>
        @else
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}">{{ __('plugin:post-type::default.edit') }}</a> | </span>
        <span class="delete"><a onclick="return confirm('Yakin ingin memindahkan data ke trash?');" href="{{ route('admin.'.get_current_post_type_args('route').'.trash', $post->id) }}" class="sa-warning">{{ __('plugin:post-type::default.trash') }}</a> | </span>
        <span class="view"><a target="_BLANK" href="{{ get_post_permalink($post) }}">{{ __('plugin:post-type::default.view') }}</a></span>
        @endif
    </div>
</td>
