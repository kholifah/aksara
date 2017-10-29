<td>
    @if($post->post_status == 'trash')
    <a href="{{ route('admin.'.get_current_post_type_args('route').'.restore', $post->id) }}" class="icon-edit sa-warning"><i title="Restore" class="fa fa-reply"></i></a>
    <a onclick="return confirm('Yakin ingin menghapus data?');" href="{{ route('admin.'.get_current_post_type_args('route').'.destroy', $post->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
    @else
    <a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
    <a onclick="return confirm('Yakin ingin memindahkan data ke trash?');" href="{{ route('admin.'.get_current_post_type_args('route').'.trash', $post->id) }}" class="icon-delete sa-warning"><i title="Trash" class="fa fa-trash-o"></i></a>
    @endif
</td>
