<div>
    @if( get_post_meta($post->id,'image',false) )
    <img class='img-responsive' src="{!! url(get_post_meta($post->id,'image')) !!}">
    @else
    -
    @endif
</div>
