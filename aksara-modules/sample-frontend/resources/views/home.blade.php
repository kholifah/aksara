@extends('sample-frontend::layouts.layout') @section('content')
<!-- Page Header -->
<header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h1>Aksara Homepage Sample</h1>
                    <span class="subheading">Super Aksara CMS</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            @if( $data['posts'] )
                @foreach ($data['posts'] as $post)
                    <div class="post-preview">
                        <a href="{{ get_post_permalink($post) }}">
                            <h2 class="post-title">
                                {{ get_post_title($post) }}
                            </h2>
                            <h3 class="post-subtitle">
                                {{ get_post_excerpt($post) }}
                            </h3>
                        </a>
                        <p class="post-meta">
                            Posted by <a href="#">{{ $post->author->name }}</a> {{ $post->post_date }}
                        </p>
                    </div>
                    <hr>
                @endforeach
                {{ $data['posts']->appends(\Request::except('page'))->links('sample-frontend::partials.pagination') }}
            @else
            <h2> No Post Found.. </h2>
            @endif
        </div>
    </div>
</div>
@endsection
