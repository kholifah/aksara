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
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>

                    <div class="container">
                        <div class="content__head">
                            <h2 class="page-title">Menu</h2>
                        </div>
                        <!-- /.content__head -->

                        <div class="content__body page-slider">
                            <div class="vertical-tabs row">
                                <ul class="nav nav-pills nav-stacked col-md-2">
                                    <li class="active">
                                        <a href="#homepage" data-toggle="pill">Menu Homepage</a>
                                    </li>
                                    <li>
                                        <a href="#footer" data-toggle="pill">Menu Footer</a>
                                    </li>
                                </ul>
                                <div class="card-box col-md-10">
                                    <div class="tab-content">                                       
                                        <div class="tab-pane active" id="homepage"> 
                                            <form action="">
                                                <div class="tab-pane__body repeat-wrap">
                                                    <h2>Menu Homepage <a href="javascript:void(0);" class="page-title-action repeat-trigger">Tambah Menu</a></h2>

                                                    <!-- Repeatable Base -->
                                                    <div class="item-box repeatable-base">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-1 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 2</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-2 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 3</span>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-2 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 3</span>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane__footer">
                                                    <div class="submit-row clearfix">
                                                        <a href="#" class="btn btn-md btn-danger alignleft">Hapus Menu Homepage</a>
                                                        <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Menu Homepage">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="footer">
                                            <form action="">
                                                <div class="tab-pane__body repeat-wrap">
                                                    <h2>Menu Footer <a href="javascript:void(0);" class="page-title-action repeat-trigger" data-max="10">Tambah Menu</a></h2>

                                                    <!-- Repeatable Base -->
                                                    <div class="item-box repeatable-base">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>
                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div>

                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>

                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-1 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 2</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-2 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 3</span>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    <div class="item-box item-box__depth-2 repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Sub Menu Level 3</span>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="item-box repeatable">
                                                        <div class="clearfix toggle-showmore">
                                                            <div class="item-box--title alignleft">
                                                                <span>Menu Item</span>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-3 m-l-10" style="display:none;">Tambah Sub Item</a>
                                                                <a href="javascript:void(0);" class="page-title-link repeat-trigger-submenu-2 m-l-10">Tambah Sub Item</a>
                                                            </div>
                                                            
                                                            <div class="alignright btn-action-group">
                                                                <a href="#" class="btn-action btn-action-danger repeat-delete" title="Delete"><i class="fa fa-trash-o"></i></a>

                                                                <a href="#" class="btn-action btn-action-primary" title="Show more"><i class="fa fa-angle-down"></i></a>
                                                            </div>
                                                        </div>

                                                        <div class="item-box--more">
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Label</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control form-item-title">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">CSS Classes</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">URL Menu</label>
                                                                <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane__footer">
                                                    <div class="submit-row clearfix">
                                                        <a href="#" class="btn btn-md btn-danger alignleft">Hapus Menu Person</a>
                                                        <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan Menu Person">
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
        
        <!-- Apps Js -->
        <?php include 'components/footer.php' ?>
    </body>
</html>