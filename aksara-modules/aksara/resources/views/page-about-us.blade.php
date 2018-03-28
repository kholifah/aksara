@extends('aksara::layouts.layout') @section('content')
<!-- Page Header -->
<header class="masthead"
    @if(get_post_featured_image($data['post']->id))
        style="background-image: url('{{ get_post_featured_image($data['post']->id,'masthead') }}')"
    @endif
>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>{{ get_post_title($data['post']) }}</h1>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<article>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
              {!! get_post_content($data['post']) !!}
      </div>
    </div>
  </div>
</article>

@endsection
