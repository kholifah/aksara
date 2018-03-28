@extends('aksara::layouts.layout') @section('content')
<!-- Page Header -->
<header class="masthead" style="background-image: url('img/home-bg.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="site-heading">
                    <h2>{{ get_archive_title() }}</h2>
                    <span class="subheading">{{ get_search_results() }}</span>
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
                            @lang('aksara::global.posted-by') <a href="#">{{ $post->author->name }}</a> {{ $post->post_date }}
                        </p>
                    </div>
                    <hr>
                @endforeach
                {{ $data['posts']->appends(\Request::except('page'))->links('aksara::partials.pagination') }}
            @else
            <h2>@lang('aksara::validation.no-posttype-found-message')</h2>
            @endif
        </div>
    </div>
</div>
@endsection
