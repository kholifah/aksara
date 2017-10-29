<?php if(empty($_GET['edit'])) { ?>

<!DOCTYPE html>
<html>
    <head>
        <?php include 'components/meta-tag.php'; ?>
        
        <!-- Plugin Style -->
        <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

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
                        <li class="breadcrumb-item active">Semua Post</li>
                    </ol>
                    <!-- /.breadcrumb -->

                    <div class="container">
                        <div class="content__head">
                            <h2 class="page-title">Semua Post <a href="add-post.php" class="page-title-action">Tambah Post</a></h2>
                        </div>
                        <!-- /.content__head -->

                        <?php
                            $string = file_get_contents('data/post.json');
                            $posts = json_decode($string, true);

                            $all_posts = [];
                            foreach ($posts as $key => $post) {                                
                                if ($post['status'] != 'Trash') {
                                    $all_posts[] = $post;                                    
                                }
                            }

                            $key_publish = array_keys(array_column($posts, 'status'), 'Published');
                            $key_trash = array_keys(array_column($posts, 'status'), 'Trash');
                            $key_draft = array_keys(array_column($posts, 'status'), 'Draft');

                            $all = count($all_posts);
                            $publish = count($key_publish);
                            $trash = count($key_trash);
                            $draft = count($key_draft);

                            if(isset($_GET['status'])) {
                                $status = $_GET['status'];
                                $all_posts = [];
                                foreach ($posts as $key => $post) {                                
                                    if ($post['status'] == $status) {
                                        $all_posts[] = $post;                                    
                                    }
                                }
                            }                          
                        ?>

                        <div class="content__body">
                            <ul class="trash-sistem">
                                <li>
                                    <a href="all-post.php" <?php if(empty($_GET['status'])) echo 'class="current"' ?> >All <span class="count">(<?=$all?>)</span></a> |
                                </li>
                                <li>
                                    <a href="all-post.php?status=Published" <?php if(isset($_GET['status']) && $_GET['status'] == 'Published') echo 'class="current"' ?>>Published <span class="count">(<?=$publish?>)</span></a> |
                                </li>
                                <li>
                                    <a href="all-post.php?status=Draft" <?php if(isset($_GET['status']) && $_GET['status'] == 'Draft') echo 'class="current"' ?>>Draft <span class="count">(<?=$draft?>)</span></a> |
                                </li>
                                <li>
                                    <a href="all-post.php?status=Trash" <?php if(isset($_GET['status']) && $_GET['status'] == 'Trash') echo 'class="current"' ?>>Trash <span class="count">(<?=$trash?>)</span></a>
                                </li>
                            </ul>
                            <div class="tablenav top clearfix">
                                <div class="alignleft action bulk-action">
                                    <form action="" class="posts-filter clearfix">
                                        <select class="form-control"> 
                                            <?php if(isset($_GET['status']) && $_GET['status'] == 'Trash') { ?>
                                                <option disabled selected>Bulk Action</option>
                                                <option>Restore</option>
                                                <option>Delete Permanently</option>
                                            <?php } else { ?>
                                                <option disabled selected>Bulk Action</option>
                                                <option>Move to Trash</option>
                                            <?php } ?>
                                        </select>
                                        <input type="submit" class="btn btn-secondary" value="Apply">
                                    </form>
                                </div>
                                <div class="alignleft action filter-box">
                                    <form action="" class="posts-filter clearfix">
                                        <select class="form-control">
                                            <option>Semua Kategori</option>
                                            <option>Berita</option>
                                            <option>Olahraga</option>
                                            <option>Politik</option>
                                            <option>Featured</option>
                                        </select>
                                        <input type="submit" class="btn btn-secondary" value="Filter">
                                    </form>
                                </div>
                                <div class="alignleft search-box">
                                    <form action="" class="posts-filter clearfix">
                                        <input type="text" class="form-control">
                                        <input type="submit" class="btn btn-secondary" value="Search">
                                    </form>
                                </div>
                                <div class="tablenav-pages"><span class="displaying-num">6 items</span>
                                    <span class="pagination-links">
                                        <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
                                        <span id="table-paging" class="paging-input">1 of <span class="total-pages">2</span></span>
                                        <a class="next-page" href="#"><span aria-hidden="true">›</span></a>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
                                    </span>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="datatable-responsive table noborder-top display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="no-sort check-column" width="20">
                                                <div class="checkbox checkbox-single checkall">
                                                    <input type="checkbox">
                                                    <label></label>
                                                </div>
                                            </th>
                                            <th>Judul</th>
                                            <th width="100">Kategori</th>
                                            <th width="100">Status</th>
                                            <th class="no-sort" width="50">Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($all_posts as $key => $all_post) { ?>
                                        <tr>
                                            <td class="check-column">
                                                <div class="checkbox checkbox-single">
                                                    <input type="checkbox">
                                                    <label></label>
                                                </div>
                                            </td>
                                            <td><?=$all_post['post_title']?></td>
                                            <td><?=$all_post['category']?></td>
                                            <td><?=$all_post['status']?></td>
                                            <td>
                                                <a href="all-post.php?edit=<?=$all_post['id']?>" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                                <a href="#" class="icon-delete sa-warning"><i title="Delete" class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>                                
                            </div>
                            <div class="tablenav bottom clearfix">
                                <div class="alignleft action bulk-action">
                                    <form action="" class="posts-filter clearfix">
                                        <select class="form-control"> 
                                            <?php if(isset($_GET['status']) && $_GET['status'] == 'Trash') { ?>
                                                <option disabled selected>Bulk Action</option>
                                                <option>Restore</option>
                                                <option>Delete Permanently</option>
                                            <?php } else { ?>
                                                <option disabled selected>Bulk Action</option>
                                                <option>Move to Trash</option>
                                            <?php } ?>
                                        </select>
                                        <input type="submit" class="btn btn-secondary" value="Apply">
                                    </form>
                                </div>
                                <?php if(isset($_GET['status']) && $_GET['status'] == 'Trash') { ?>
                                    <div class="alignleft">
                                        <input type="submit" class="btn btn-secondary" value="Empty Trash">
                                    </div>
                                <?php }?>
                                
                                <div class="tablenav-pages"><span class="displaying-num">6 items</span>
                                    <span class="pagination-links">
                                        <span class="tablenav-pages-navspan" aria-hidden="true">«</span>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
                                        <span id="table-paging" class="paging-input">1 of <span class="total-pages">2</span></span>
                                        <a class="next-page" href="#"><span aria-hidden="true">›</span></a>
                                        <span class="tablenav-pages-navspan" aria-hidden="true">»</span>
                                    </span>
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

        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>       
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/js-init/jquery.sweet-alert2.init.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                var oTable = $('.datatable-responsive').DataTable({
                    paging: false,
                    ordering: true,
                    info: false,
                    searching: false,
                    order: [],
                    columnDefs: [
                      { targets: 'no-sort', orderable: false }
                    ],
                    responsive: true
                });

                oTable.on( 'responsive-display', function ( e, datatable, row, showHide, update ) {
                    $('.sa-success').click(function () {
                        swal({
                            title: 'Sukses!',
                            text: 'Data telah tersimpan.',
                            type: 'success',
                            confirmButtonColor: '#4fa7f3'
                        })
                    });
                    $('.sa-warning').click(function () {
                        swal({
                            title: 'Are you sure?',
                            text: "You will not be able to recover this selected file!",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d57171',
                            cancelButtonColor: '#b7b7b7',
                            confirmButtonText: 'Delete'
                        }).then(function () {
                            swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        })
                    });
                });
            });
        </script>
    </body>
</html>

<?php } else { 
    include 'add-post.php';
} ?>