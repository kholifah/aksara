<td>
    @if( get_post_image($post->id) )
    <img class='img-responsive' style='max-height:150px' src="{!! get_post_image($post->id) !!}">
    @else
    -
    @endif
</td>
