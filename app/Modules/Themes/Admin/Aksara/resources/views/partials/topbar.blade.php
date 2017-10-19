<!-- LOGO -->
<div class="topbar-left">
    <div class="text-left">
        <a href="{{ url('/') }}" class="logo">
            <img src="{{ asset('assets/admin/dist/images/logo_white.png') }}" class="icon-c-logo icon-collapse">
            <span>@filter('aksara.application_name','Aksara')</span>
        </a>
        <!-- Image Logo here -->
        <!--<a href="index.html" class="logo">-->
            <!--<i class="icon-c-logo"> <img src="dist/images/logo_sm.png" height="42"/> </i>-->
            <!--<span><img src="dist/images/logo_light.png" height="20"/></span>-->
        <!--</a>-->
    </div>
</div>

<!-- Button mobile view to collapse sidebar menu -->
<div class="navbar navbar-default" role="navigation">
    <div class="container nopadding">
        <div class="clearfix">
            <div class="pull-left">
                <button class="button-menu-mobile open-left waves-effect waves-light">
                    <i class="md md-menu"></i>
                </button>
                <span class="clearfix"></span>
            </div>

            <ul class="nav navbar-nav pull-left navbar-title">
                <li><span class="waves-effect waves-light ellips">@filter('aksara.tagline','CMS Mirip WordPress')</span></li>
            </ul>
            <ul class="nav navbar-nav navbar-right pull-right">
                <li class="dropdown top-menu-item-xs">
                    <a href="#" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true">
                        <i class="fa fa-user m-r-5" aria-hidden="true"></i>
                        <span class="name">{{ \Auth::user()->name }}</span>
                    </a>
                    {!! render_admin_menu_toolbar_dropdown() !!}
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
