{{-- error fallback page --}}

<p>Error occurred:</p>
<div class="alert alert-danger" role="alert">
  <p>{!! $msg !!}</p>
</div>
<div>
  <a href="{{ $link_url }}">{{ $link_name }}</a>
</div>
