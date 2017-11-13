<!DOCTYPE html>
<html>
    <head>
        <?php include 'components/meta-tag.php'; ?>
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
            <!-- Start right Content -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                    </div> 
                    <!-- /.container -->
                </div> 
                <!-- /.content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Right content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->
        
        <?php include 'components/footer.php' ?>
    </body>
</html>