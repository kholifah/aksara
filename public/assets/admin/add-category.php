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
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="category.php">Kategori</a></li>
                        <?php if(isset($_GET['edit'])) { ?>
                        <li class="breadcrumb-item active">Olahraga</li>
                        <?php } else { ?>
                        <li class="breadcrumb-item active">Tambah Kategori</li>
                        <?php } ?>
                    </ol>

                    <div class="container">
                        <div class="content__head">
                            <?php if(isset($_GET['edit'])) { ?>
                            <h2 class="page-title">Edit Kategori</h2>
                            <?php } else { ?>
                            <h2 class="page-title">Tambah Kategori</h2>
                            <?php } ?>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body">
                            <div class="row">
                                <div class="col-lg-6 col-md-8">
                                    <div class="card-box">
                                        <div class="card-box__header">
                                            <?php if(isset($_GET['edit'])) { ?>
                                            <h2 class="page-title">Edit Kategori</h2>
                                            <?php } else { ?>
                                            <h2 class="page-title">Tambah Kategori</h2>
                                            <?php } ?>
                                        </div>
                                        <div class="card-box__body">
                                            <form action="" class="form-horizontal">
                                                <div class="form-group form-group--table">
                                                    <label class="col-form-label">Judul</label>
                                                    <div class="col-form-input">
                                                        <input type="text" class="form-control" <?php if(isset($_GET['edit'])) echo "value=Olahraga" ?>>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group--table">
                                                    <label class="col-form-label">Induk</label>
                                                    <div class="col-form-input">
                                                        <select class="form-control">
                                                            <option value="">None</option>
                                                            <option value="" <?php if(isset($_GET['edit'])) echo "selected" ?>>Berita</option>
                                                            <option value="">Olahraga</option>
                                                            <option value="">Politik</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group--table">
                                                    <label class="col-form-label">Slug</label>
                                                    <div class="col-form-input">
                                                        <input type="text" class="form-control" <?php if(isset($_GET['edit'])) echo "value=olahraga" ?>>
                                                    </div>
                                                </div>
                                                <div class="submit-row clearfix">
                                                    <?php if(isset($_GET['edit'])) { ?>    
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Update Kategori">
                                                    <a href="category.php" class="btn btn-md btn-danger alignright">Cancel</a>
                                                    <?php } else { ?>
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Tambah Kategori">
                                                    <?php } ?>
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

        <?php include 'components/footer.php' ?>
    </body>
</html>