<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Tonjoo">
        <meta name="_token" content="{{ csrf_token() }}"/>
        <link rel="shortcut icon" href="{{ asset('assets/admin/dist/images/logo_sm.png') }}">

        <title>@filter('aksara.admin_site_title', 'Aksara Dashboard')</title>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        @action('aksara.admin.head')
        <!-- Base CSS -->
        <link href="{{ asset('assets/admin/dist/css/style.css') }}" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300|Noto+Sans:400,700" rel="stylesheet">

        @yield('add-header')

        <script type="text/javascript" src="{{ asset('assets/admin/dist/js/modernizr.min.js') }}"></script>

        <script type="text/javascript">
            aksara_url = "<?php echo url('/') ?>";
        </script>
    </head>

    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">
                @include('admin:aksara::partials.topbar')
            </div>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    @include('admin:aksara::partials.sidebar')
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    @yield('breadcrumb')
                    <div class="container">
                        {{ render_admin_notice() }}
                        @yield('content')
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <script>
            var resizefunc = [];
        </script>


        @yield('add-footer')

    </body>
    <footer>
        @action('aksara.admin.footer')
    </footer>
</html>
