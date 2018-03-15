<td>
    {{ $post->post_title }}
    <div class="table__actions">
        @if($post->post_status == 'trash')
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.restore', $post->id) }}">Restore</a> | </span>
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}">Edit</a> | </span>
        <span class="delete"><a onclick="return confirm('Yakin ingin menghapus data?');" href="{{ route('admin.'.get_current_post_type_args('route').'.destroy', $post->id) }}" class="sa-warning">Delete</a> | </span>
        <span class="view"><a target="_BLANK" href="{{ get_post_permalink($post) }}">View</a></span>
        @else
        <span class="edit"><a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}">Edit</a> | </span>
        <span class="delete"><a onclick="return confirm('Yakin ingin memindahkan data ke trash?');" href="{{ route('admin.'.get_current_post_type_args('route').'.trash', $post->id) }}" class="sa-warning">Trash</a> | </span>
        <span class="view"><a target="_BLANK" href="{{ get_post_permalink($post) }}">View</a></span>
        @endif
    </div>
</td>