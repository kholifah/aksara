<?php
// return;
\App::singleton('post',function()
{
  $post =  new \App\Modules\Plugins\PostType\Post();
  return $post;
});

\App::singleton('App\Modules\Plugins\PostType\MetaBox',function(){
  return new \App\Modules\Plugins\PostType\MetaBox();
});

\App::bind('App\Repositories\PostRepositoryInterface', 'App\Repositories\PostRepository');
\App::bind('App\Repositories\TaxonomyRepositoryInterface', 'App\Repositories\TaxonomyRepository');


\Eventy::addAction('aksara.init_completed',function(){
  $post = \App::make('post');

  // Register Post
  $argsPost = [
    'label' => [
      'name' => 'Post'
    ],
    'route' => 'post',
    'icon' => 'ti-write'
  ];

  $post->registerPostType('post',$argsPost);

  // Register Page
  $argsPage = [
    'label' => [
      'name' => 'Page'
    ],
    'route' => 'page',
    'icon' => 'ti-book'
  ];

  $post->registerPostType('page',$argsPage);

   // Register Taxonomy
  $argsCategory = [
    'label' => [
      'name' => 'Category'
    ],
  ];

  $post->registerTaxonomy('category', ['post'], $argsCategory);

  $argsTag = [
    'label' => [
      'name' => 'Tag'
    ],
  ];

  $post->registerTaxonomy('tag', ['post'], $argsTag);
});

\Eventy::addAction('aksara.admin_head',function()
{
    echo '<link href='.url("assets/admin/assets/plugins/datatables/jquery.dataTables.min.css").' rel="stylesheet" type="text/css"/>';
    echo '<link href='.url("assets/admin/assets/plugins/datatables/responsive.bootstrap.min.css").' rel="stylesheet" type="text/css"/>';
});

\App::singleton('aksara.admin_footer',function(){
\Eventy::addAction('aksara.admin_footer',function()
{
    // File JS / CSS masuk sini
    // @nanti dipindah ke resource
    echo '<script src='.url("assets/admin/assets/plugins/datatables/jquery.dataTables.min.js").'></script>';
    echo '<script src='.url("assets/admin/assets/plugins/datatables/dataTables.responsive.min.js").'></script>';
    echo '<script src='.url("assets/admin/assets/pages/datatables.init.js").'></script>';
    echo "<script type='text/javascript'>
            $(document).ready(function () {
                var oTable = $('.datatable-responsive').DataTable({
                    paging: false,
                    ordering: true,
                    info: false,
                    searching: false,
                    order: [],
                    columnDefs: [
                        {targets: 'no-sort', orderable: false}
                    ],
                    responsive: true
                });
                oTable.on('responsive-display', function (e, datatable, row, showHide, update) {
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
                            text: 'You will not be able to recover this selected file!',
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
        </script>";
});
});
