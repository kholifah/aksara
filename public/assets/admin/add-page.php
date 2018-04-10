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
                <?php
                    $string = file_get_contents('data/page.json');
                    $posts = json_decode($string, true);

                    if($_GET) {
                        $post_id = $_GET['edit'];
                        $key = array_search($post_id, array_column($posts, 'id'));
                        $post = $posts[$key];
                    } else {
                        $post = -1;
                    }
                ?>

                <!-- Start content -->
                <div class="content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="all-post.php">Semua Laman</a></li>
                        <?php if(isset($_GET['edit'])) { ?>
                        <li class="breadcrumb-item active"><?=$post['post_title']?></li>
                        <?php } else { ?>
                        <li class="breadcrumb-item active">Tambah Laman</li>
                        <?php } ?>
                    </ol>

                    <div class="container">
                        <div class="content__head m-b-20">
                            <?php if(isset($_GET['edit'])) { ?>
                            <h2 class="page-title">Edit Laman</h2>
                            <?php } else { ?>
                            <h2 class="page-title">Tambah Laman</h2>
                            <?php } ?>
                        </div>
                        <!-- /.content__head -->                        
                        
                        <form action="" method="post">
                            <div class="content__body column-2">
                                <div class="container-content">
                                    <div class="post-box title-field">
                                        <div class="title-field-wrap">
                                            <input type="text" class="form-control" placeholder="Judul Post" value="<?=$post['post_title']?>">
                                        </div>                                        

                                        <?php if(isset($_GET['edit'])) { ?>
                                            <div class="edit-slug-box">
                                                <strong>Permalink:</strong>
                                                <span class="sample-permalink">
                                                    <a href="<?=$base_url.'/'.$post['slug'].'/'?>"><?=$base_url.'/'?><span id="editable-post-name"><?=$post['slug']?>/</span>
                                                    </a>
                                                    <input type="text" autocomplete="off" value="<?=$post['slug']?>" id="new-post-slug">
                                                </span>
                                                ‎<span id="edit-slug-buttons">
                                                    <button type="button" class="edit-slug btn btn-secondary">Edit</button>
                                                </span>
                                            </div>
                                        <?php } else { ?>
                                            <div class="slug-wrap clearfix">
                                                <label>Slug</label>
                                                <input type="text" class="form-control" placeholder="Slug">
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="post-box">
                                        <textarea id="texteditor" class="form-control" aria-hidden="true"><?=$post['post_content']?></textarea>
                                    </div>

                                    <div class="card-box">
                                        <div class="card-box__header">
                                            <h2>Post Meta</h2>
                                        </div>
                                        <div class="card-box__body">
                                            <div action="" class="form-horizontal">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Select</label>
                                                    <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                        <select class="form-control">
                                                            <option value="">Opsi 1</option>
                                                            <option value="" <?php if(isset($_GET['edit'])) echo "selected"; ?>>Opsi 2</option>
                                                            <option value="">Opsi 3</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-xs-4 col-xxs-12 col-form-label">Slug</label>
                                                    <div class="col-sm-10 col-xs-8 col-xxs-12">
                                                        <input type="text" class="form-control" <?php if(isset($_GET['edit'])) echo "value=Example"; ?>>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="container-sidebar">
                                    <div class="card-box post-box">
                                        <div class="card-box__header">
                                            <h2>Terbitkan</h2>
                                        </div>
                                        <div class="card-box__body form-horizontal">               
                                            <div class="form-group form-group--table">
                                                <label class="col-form-label col-form-label col-form-label--sm">Status</label>
                                                <div class="col-form-input">
                                                    <select class="form-control form-sm">
                                                        <option value="" <?php if($post['status'] == 'Draft') echo "selected"; ?>>Draft</option>
                                                        <option value="" <?php if($post['status'] == 'Pending') echo "selected"; ?>>Pending Review</option>
                                                        <option value="" <?php if($post['status'] == 'Published') echo "selected"; ?>>Publish</option>
                                                    </select>
                                                </div>
                                            </div>                                                
                                        </div> 
                                        <div class="card-box__footer">
                                            <div class="submit-row clearfix">
                                                <input type="submit" class="btn btn-md btn-primary alignright" value="Simpan">
                                            </div>
                                        </div>                                   
                                    </div>
                                    <div class="card-box post-box">
                                        <div class="card-box__header">
                                            <h2>Foto Utama</h2>
                                        </div>
                                        <div class="card-box__body">               
                                            <div class="form-img clearfix">
                                                <?php if(isset($_GET['edit'])) { ?>
                                                    <div class="image-preview" style="display:block">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="<?=$post['thumb']?>">
                                                    </div>
                                                    <p class="info" style="display:block">Klik icon pada gambar untuk menghapus</p>
                                                <?php } else { ?>
                                                    <div class="image-preview">
                                                        <a href="#" class="img-remove"><i class="ti-trash"></i></a>
                                                        <img class="previewing" src="">
                                                    </div>
                                                    <p class="info">Klik icon pada gambar untuk menghapus</p>
                                                <?php } ?>                                   
                                                
                                                <p class="info-error">type file yang anda pilih salah</p>
                                                <label class="form-file-wrapper btn btn-secondary">
                                                    Set Foto Utama
                                                    <input class="file" type="file" name="gambar-utama">               
                                                </label>
                                            </div>                                                
                                        </div>                                  
                                    </div>
                                    <div class="card-box post-box">
                                        <div class="card-box__header">
                                            <h2 class="clearfix">Kategori <a href="add-category.php" class="page-title-link alignright">Add New</a></h2>
                                        </div>
                                        <div class="card-box__body category-wrap">
                                            <ul class="unstyle-list js-scroll">
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="berita" type="checkbox" <?php if(isset($_GET['edit'])) echo "checked"; ?>>
                                                        <label for="berita">Berita</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="olahraga" type="checkbox">
                                                        <label for="olahraga">Olahraga</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="politik" type="checkbox">
                                                        <label for="politik">Politik</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="berita" type="checkbox">
                                                        <label for="berita">Berita</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="olahraga" type="checkbox">
                                                        <label for="olahraga">Olahraga</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="politik" type="checkbox">
                                                        <label for="politik">Politik</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="berita" type="checkbox">
                                                        <label for="berita">Berita</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="olahraga" type="checkbox">
                                                        <label for="olahraga">Olahraga</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="politik" type="checkbox">
                                                        <label for="politik">Politik</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="berita" type="checkbox">
                                                        <label for="berita">Berita</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="olahraga" type="checkbox">
                                                        <label for="olahraga">Olahraga</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="checkbox checkbox-inline">
                                                        <input id="politik" type="checkbox">
                                                        <label for="politik">Politik</label>
                                                    </div>
                                                </li>
                                            </ul>                                              
                                        </div>                                 
                                    </div>
                                </div>
                            </div>
                            <!-- /.content__body -->
                        </form>
                    </div> <!-- container -->
                </div> <!-- content -->
            </div>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <?php include 'components/footer.php' ?>

        <!-- Wysiwig js-->
        <script src="assets/plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                if($("#texteditor").length > 0){
                    tinymce.init({
                        selector: "textarea#texteditor",
                        theme: "modern",
                        height:300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                        style_formats: [
                            {title: 'Header 1', format: 'h1'},
                            {title: 'Header 2', format: 'h2'},
                            {title: 'Header 3', format: 'h3'},
                            {title: 'Header 4', format: 'h4'},
                            {title: 'Header 5', format: 'h5'},
                            {title: 'Header 6', format: 'h6'},
                            {title: 'Code', icon: 'code', format: 'code'}                      
                        ]
                    });
                }
            });
        </script>
    </body>
</html>