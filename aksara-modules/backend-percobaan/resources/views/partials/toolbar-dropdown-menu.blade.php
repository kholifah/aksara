<ul class="dropdown-menu">
@foreach($adminMenus as $adminMenu)
    @foreach ($adminMenu as $menu)
        <li><a href="{{ $menu['url'] }}"><i class="m-r-10 {{ $menu['class'] }}"></i>{{ $menu['title'] }}</a></li>
    @endforeach
@endforeach
</ul>
