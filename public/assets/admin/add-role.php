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
                        <li class="breadcrumb-item"><a href="role.php">Role</a></li>
                        <?php if(isset($_GET['edit'])) { ?>
                        <li class="breadcrumb-item active">Admin</li>
                        <?php } else { ?>
                        <li class="breadcrumb-item active">Tambah Role</li>
                        <?php } ?>
                    </ol>

                    <div class="container">
                        <div class="content__head">
                            <?php if(isset($_GET['edit'])) { ?>
                            <h2 class="page-title">Edit Role</h2>
                            <?php } else { ?>
                            <h2 class="page-title">Tambah Role</h2>
                            <?php } ?>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="card-box">
                                        <div class="card-box__header">
                                            <?php if(isset($_GET['edit'])) { ?>
                                            <h2 class="page-title">Edit Role</h2>
                                            <?php } else { ?>
                                            <h2 class="page-title">Tambah Role</h2>
                                            <?php } ?>
                                        </div>
                                        <div class="card-box__body">
                                            <form action="" class="form-horizontal">
                                                <div class="form-group form-group--table m-b-30">
                                                    <label class="col-form-label">Nama Role</label>
                                                    <div class="col-form-input">
                                                        <input type="text" class="form-control" <?php if(isset($_GET['edit'])) echo "value=Admin" ?>>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="post" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="post">Post</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="add_post" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="add_post">add_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_post" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_post">edit_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_posts" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_posts">edit_posts</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_post" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_post">publish_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_posts" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_posts">publish_posts</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="page" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="page">Page</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="add_page" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="add_page">add_page</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_page" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_page">edit_page</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_pages" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_pages">edit_pages</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_page" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_page">publish_page</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_pages" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_pages">publish_pages</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="portofolio" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="portofolio">Portofolio</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="add_portofolio" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="add_portofolio">add_portofolio</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_portofolio" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_portofolio">edit_portofolio</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_portofolios" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_portofolios">edit_portofolios</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_portofolio" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_portofolio">publish_portofolio</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_portofolios" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_portofolios">publish_portofolios</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="post_jenis" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="post_jenis">Post [jenis]</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="add_post1" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="add_post1">add_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_post1" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_post1">edit_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_posts1" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_posts1">edit_posts</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_post1" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_post1">publish_post</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_posts1" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_posts1">publish_posts</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="banner" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="banner">Banner</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_banner" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_banner">manage_banner</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="menu" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="menu">Menu</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_menu" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_menu">manage_menu</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="slider" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="slider">Slider</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_slider" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_slider">manage_slider</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="options" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="options">Options</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_options" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_options">manage_options</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="user" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="user">User</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_user" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_user">manage_user</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="manage_role" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="manage_role">manage_role</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="checkbox-group checkbox-role">
                                                            <div class="checkbox-role--parent">
                                                                <div class="checkbox checkbox-inline checkall">
                                                                    <input type="checkbox" id="varian_dinamis" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                    <label for="varian_dinamis">Varian Dinamis</label>
                                                                </div>
                                                            </div>
                                                            <ul class="checkbox-role--advance">
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="add_[$post_type]" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="add_[$post_type]">add_[$post_type]</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_[$post_type]" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_[$post_type]">edit_[$post_type]</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="edit_[$post_type]s" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="edit_[$post_type]s">edit_[$post_type]s</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_[$post_type]" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_[$post_type]">publish_[$post_type]</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="checkbox checkbox-inline">
                                                                        <input type="checkbox" id="publish_[$post_type]s" <?php if(isset($_GET['edit'])) echo "checked" ?>>
                                                                        <label for="publish_[$post_type]s">publish_[$post_type]s</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="submit-row clearfix">
                                                    <?php if(isset($_GET['edit'])) { ?>
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Update Role">
                                                    <a href="role.php" class="btn btn-md btn-danger alignright">Cancel</a>
                                                    <?php } else { ?>
                                                    <input type="submit" class="btn btn-md btn-primary alignright" value="Tambah Role">
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