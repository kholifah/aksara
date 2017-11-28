<td>
	{{ $post->post_title }} 
	<div class="row">
		<div class="col-md-12" style="padding-left: 7px;">
		@if($post->post_status == 'trash')
	    <a href="{{ route('admin.'.get_current_post_type_args('route').'.restore', $post->id) }}" class="icon-edit sa-warning" style="font-size: .8rem;">Restore</a>
	    <a onclick="return confirm('Yakin ingin menghapus data?');" href="{{ route('admin.'.get_current_post_type_args('route').'.destroy', $post->id) }}" class="icon-delete sa-warning" style="font-size: .8rem;">Delete</a>
	    @else
	    <a href="{{ route('admin.'.get_current_post_type_args('route').'.edit', $post->id) }}" class="icon-edit" style="font-size: .8rem;">Edit </a>
	    <a onclick="return confirm('Yakin ingin memindahkan data ke trash?');" href="{{ route('admin.'.get_current_post_type_args('route').'.trash', $post->id) }}" class="icon-delete sa-warning" style="font-size: .8rem;">Trash</a>
	    @endif
		</div>
	</div>
</td>
