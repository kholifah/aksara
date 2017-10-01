<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="dist/images/logo_sm.png">

    <title>Tambah Taxonomy</title>

    <!-- Base CSS -->
    <link href="dist/css/style.css" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="dist/js/modernizr.min.js"></script>
</head>

    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">
                <?php include "components/main_navbar.php"; ?>
            </div>
            <!-- Top Bar End -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <?php include "components/main_sidebar.php" ; ?>
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
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="daftar-taxonomy.php">Taxonomy</a></li>
                        <li class="breadcrumb-item active">Tambah Taxonomy</li>
                    </ol>

                    <div class="container">
                        <div class="content__head">
                            <h2 class="page-title">Tambah Taxonomy</h2>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body">
                            <div class="row">
                                <div class="col-lg-8 col-md-11">
                                    <div class="card-box">
                                        <div class="card-box__header">
                                            <h2>Tambah Taxonomy</h2>
                                        </div>
                                        <div class="card-box__body">
                                            <form action="" class="form-horizontal">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                                    <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                        <input type="text" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Post Type</label>
                                                    <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                        <select class="form-control">
                                                            <option value="">Berita</option>
                                                            <option value="">Olahraga</option>
                                                            <option value="">Politik</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="submit-row clearfix">
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Tambah Taxonomy">
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.content__body -->
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
        
        <script src="dist/js/script.min.js"></script>
    </body>
</html>