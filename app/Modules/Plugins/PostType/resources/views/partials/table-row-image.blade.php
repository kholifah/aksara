<td>
    @if( get_post_meta($post->id,'image',false) )
    <img class='img-responsive' style='max-height:150px' src="{!! get_post_meta($post->id,'image') !!}">
    @else
    -
    @endif
</td>
