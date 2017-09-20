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
                            <h2 class="page-title">Opsi Tampilan</h2>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body page-slider">
                            <div class="vertical-tabs row">
                                <ul class="nav nav-pills nav-stacked col-md-2">
                                    <li class="active">
                                        <a href="#opsi-homepage" data-toggle="pill">Opsi Homepage</a>
                                    </li>
                                    <li>
                                        <a href="#opsi-kontakform" data-toggle="pill">Opsi Kontak Form</a>
                                    </li>
                                </ul>
                                <div class="card-box col-md-10">
                                    <div class="tab-content">                                      
                                        <div class="tab-pane active" id="opsi-homepage"> 
                                            <form action="">
                                                <div class="tab-pane__body">
                                                    <h2 class="border-title">Lorem ipsum dolor</h2>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Judul</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <textarea name="" id="code-editor" rows="7" class="code-editor"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Lorem ipsum</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <input type="text" class="form-control">
                                                        </div>
                                                    </div>

                                                    <h2 class="border-title m-t-40">Lorem ipsum dolor</h2>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Lorem ipsum</label>
                                                        <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                            <select class="form-control"> 
                                                                <option>Opsi 1</option>
                                                                <option>Opsi 2</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane__footer">
                                                    <div class="submit-row clearfix">
                                                        <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Pengaturan">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="opsi-kontakform">
                                            <form action="">
                                                <div class="tab-pane__body repeat-wrap">
                                                    <h2>Kontak Form</h2>
                                                    <div class="tag-generator">
                                                        <button class="btn btn-secondary" data-type="text">text</button>
                                                        <button class="btn btn-secondary" data-type="email">email</button>
                                                        <button class="btn btn-secondary" data-type="url">URL</button>
                                                        <button class="btn btn-secondary" data-type="tel">tel</button>
                                                        <button class="btn btn-secondary" data-type="number">number</button>
                                                        <button class="btn btn-secondary" data-type="textarea">textarea</button>
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

                                                <div class="tab-pane__footer">
                                                    <div class="submit-row clearfix">
                                                        <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Kontak Form">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>                                   
                                    </div>
                                    <!-- tab content -->                                    
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

        <!-- Plugin Script -->
        <script src="assets/plugins/codemirror/js/codemirror.js"></script>
        <script src="assets/plugins/codemirror/js/javascript.js"></script>
        
        <!-- Apps Js -->
        <?php include 'components/footer.php' ?>
    </body>
</html>