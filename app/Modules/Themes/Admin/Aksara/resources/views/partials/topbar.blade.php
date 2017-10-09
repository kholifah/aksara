<!-- LOGO -->
<div class="topbar-left">
    <div class="text-left">
        <a href="#" class="logo">
            <img src="{{ asset('assets/admin/dist/images/logo_white.png') }}" class="icon-c-logo icon-collapse">
            <span><!-- <img src="dist/images/logo_white.png"> --> @filter('aksara.application_name','Aksara')</span>
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

            <!-- <form role="search" class="navbar-left app-search pull-left hidden-xs">
               <input type="text" placeholder="Search..." class="form-control">
               <a href=""><i class="fa fa-search"></i></a>
            </form> -->


            <ul class="nav navbar-nav navbar-right pull-right">
                <!-- <li class="hidden-xs">
                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                </li> -->
                <li class="dropdown top-menu-item-xs">
                    <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light notif" data-toggle="dropdown" aria-expanded="true">
                        <i class="icon-bell fs-1"></i> <span class="badge badge-danger">6</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg">
                        <li class="notifi-title"><span class="label label-default pull-right">Baru 6</span>Notifikasi</li>
                        <li class="list-group slimscroll-noti notification-list">
                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-diamond noti-primary"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                        <p class="m-0">
                                            <small>There are new settings available</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-cog noti-warning"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">New settings</h5>
                                        <p class="m-0">
                                            <small>There are new settings available</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-bell-o noti-custom"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">Updates</h5>
                                        <p class="m-0">
                                            <small>There are <span class="text-primary font-600">2</span> new updates available</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-user-plus noti-pink"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">New user registered</h5>
                                        <p class="m-0">
                                            <small>You have 10 unread messages</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-diamond noti-primary"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">A new order has been placed A new order has been placed</h5>
                                        <p class="m-0">
                                            <small>There are new settings available</small>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- list item-->
                            <a href="javascript:void(0);" class="list-group-item">
                                <div class="media">
                                    <div class="pull-left p-r-10">
                                        <em class="fa fa-cog noti-warning"></em>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">New settings</h5>
                                        <p class="m-0">
                                            <small>There are new settings available</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notifi-footer">
                            <a href="notifikasi.php" class="list-group-item text-right">
                                <small class="font-600">Lihat semua notifikasi</small>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="dropdown top-menu-item-xs">
                    <a href="#" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                        <img src="{{ asset('assets/admin/dist/images/users/avatar-1.jpg') }}" alt="user-img" class="img-circle"> </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="ti-user m-r-10"></i> Profile</a></li>
                        <li><a href="#"><i class="ti-agenda m-r-10"></i> Catatan Karir</a></li>
                        <li><a href="{{ route('admin.logout') }}"><i class="ti-power-off m-r-10"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
