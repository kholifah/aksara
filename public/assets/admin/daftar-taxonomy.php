<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="dist/images/logo_sm.png">

    <title>Daftar Taxonomy</title>
    
    <!-- Plugin Style -->
    <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">

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
                        <li class="breadcrumb-item active">Taxonomy</li>
                    </ol>
                    <!-- /.breadcrumb -->
                        
                    <div class="container"> 
                        <div class="content__head">
                            <h2 class="page-title">Pengaturan Taxonomy <a href="add-taxonomy.php" class="page-title-action">Tambah Taxonomy</a></h2>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body">
                            <div class="tablenav top clearfix">
                                <div class="alignleft search-box">
                                    <form action="" class="posts-filter">
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
                                <table class="datatable-responsive table noborder-top display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                      <tr>
                                          <th>Taxonomy</th>
                                          <th>Post Type</th>
                                          <th class="no-sort" width="50">Edit</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kategori</td>
                                            <td>Post</td>
                                            <td>
                                                <a href="#" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                                <a href="#" class="icon-delete"><i title="Delete" class="sa-warning fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <td>Slider</td>
                                            <td>
                                                <a href="#" class="icon-edit"><i title="Edit" class="fa fa-pencil-square-o edit-row" data-toggle="modal" data-target="#edit-komponen"></i> </a>
                                                <a href="#" class="icon-delete"><i title="Delete" class="sa-warning fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                            <div class="tablenav bottom clearfix">
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

        <script>
            var resizefunc = [];
        </script>
        
        <script src="dist/js/script.min.js"></script>

        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>       
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/pages/datatables.init.js"></script>

        <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/pages/jquery.sweet-alert2.init.js"></script>


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
                        swal(
                            {
                                title: 'Sukses!',
                                text: 'Data telah tersimpan.',
                                type: 'success',
                                confirmButtonColor: '#4fa7f3'
                            }
                        )
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