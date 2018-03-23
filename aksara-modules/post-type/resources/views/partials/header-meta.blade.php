<title>@filter('aksara.site-title', 'Aksara')</title>
<meta name="description" content="@filter('aksara.site-description', '')">
{!! @$options['custom_meta_header'] !!}
<meta property="og:url" content="{{ $ogUrl }}" />
<meta property="og:title" content="{{ $ogTitle }}" />
<meta property="og:description" content="{{ $ogDescription }}" />
@if( $ogImage )
    <meta property="og:image" content="{{ $ogImage }}" />
@endif

<meta name="twitter:title" content="{{ $ogTitle }}" />
<meta name="twitter:description" content="{{ $ogDescription }}" />
@if( $ogImage )
<meta name="twitter:image" content="{{ $ogImage }}" />
@endif
