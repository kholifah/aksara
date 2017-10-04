<div>
    @if( get_post_image($post->id) )
    <img class='img-responsive' src="{!! get_post_image($post->id) !!}">
    @else
    -
    @endif
</div>
