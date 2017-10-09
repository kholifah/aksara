<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">@filter('aksara.tagline','Aksara Tagline')</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      Menu
      <i class="fa fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        @foreach ( get_menu('primary') as $menu)
            <li class="nav-item">
                @if( !str_contains($menu['data']['url'],'http://') )
                <a class="nav-link" href="{{url($menu['data']['url'])}}">{{ $menu['data']['label'] }}</a>
                @else
                <a class="nav-link" href="{{$menu['data']['url']}}">{{ $menu['data']['label'] }}</a>
                @endif
            </li>
        @endforeach
      </ul>
    </div>
  </div>
</nav>
