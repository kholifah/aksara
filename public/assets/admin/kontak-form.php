<!DOCTYPE html>
<html>
    <head>
        <?php include 'components/meta-tag.php'; ?>
        
        <!-- Plugin Style -->
        <link href="assets/plugins/codemirror/css/codemirror.css" rel="stylesheet" type="text/css"/>

        <?php include 'components/default-style.php'; ?>
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
                        <li class="breadcrumb-item active">Opsi Tampilan</li>
                    </ol>

                    <div class="container">
                        <div class="content__head">
                            <h2 class="page-title">Kontak Form</h2>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="card-box">
                                        <form action="">
                                            <div class="card-box__body repeat-wrap">       
                                                <div class="tag-generator">
                                                    <button class="btn btn-secondary" data-type="text">text</button>
                                                    <button class="btn btn-secondary" data-type="email">email</button>
                                                    <button class="btn btn-secondary" data-type="url">URL</button>
                                                    <button class="btn btn-secondary" data-type="tel">tel</button>
                                                    <button class="btn btn-secondary" data-type="number">number</button>
                                                    <button class="btn btn-secondary" data-type="dropdown">dropdown</button>
                                                    <button class="btn btn-secondary" data-type="checkbox">checkboxes</button>
                                                    <button class="btn btn-secondary" data-type="radio">radio buttons</button>
                                                    <button class="btn btn-secondary" data-type="file">file</button>
                                                    <button class="btn btn-secondary" data-type="submit">submit</button>
                                                </div>
                                                <div class="form-group">
                                                    <textarea id="generator-area" class="form-control" rows="20" aria-hidden="true"></textarea>
                                                </div>
                                            </div>

                                            <div class="card-box__footer">
                                                <div class="submit-row clearfix">
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Kontak Form">
                                                </div>
                                            </div>
                                        </form>
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
        
        <!-- Apps Js -->
        <?php include 'components/footer.php' ?>
    </body>
</html>