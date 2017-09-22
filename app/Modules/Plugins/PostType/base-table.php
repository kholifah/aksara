<?php
// modify post ordering
\Eventy::addAction('aksara.init_completed',function(){
    $postTypes = \Config::get('aksara.post_type');

    foreach ($postTypes as $postType => $args ) {

        \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column','post_type_base_column',1,2);
        \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row','post_type_base_row',1,2);
    }




});

function post_type_base_column($cols,$postType)
{

    $cols['quick-edit'] = ['title'=>'','width'=>'25px','class'=>'no-sort'];;
    $cols['title'] = ['title'=>'Judul'];
    $cols['status'] = ['title'=>'Status','width'=>'100px'];
    $cols['edit'] = ['title'=>'Edit','width'=>'125px','class'=>'no-sort'];;
    return $cols;
}


function post_type_base_row($colsId,$post)
{
    if( $colsId == 'quick-edit' )
        echo view('plugin:post-type::partials.table-row-quick-edit',compact('colsId','post'))->render();
    if( $colsId == 'title' )
        echo view('plugin:post-type::partials.table-row-title',compact('colsId','post'))->render();
    if( $colsId == 'status' )
        echo view('plugin:post-type::partials.table-row-status',compact('colsId','post'))->render();
    if( $colsId == 'edit' )
        echo view('plugin:post-type::partials.table-row-edit',compact('colsId','post'))->render();
}

function post_type_image_column($cols,$postType)
{
    unset($cols['title']);
    unset($cols['status']);

    $imageCol = [
        'image' => ['title'=>'Image','width'=>'200px','class'=>'image no-sort']
    ];

    insert_after_array_key($cols,'quick-edit',$imageCol);

    return $cols;
}
\Eventy::addFilter('aksara.post-type.media.index.table.column','post_type_image_column',20,2);

function post_type_image_row($colsId,$post)
{
    if( $colsId == 'image' )
        echo view('plugin:post-type::partials.table-row-image',compact('colsId','post'))->render();
}
\Eventy::addAction('aksara.post-type.media.index.table.row','post_type_image_row',1,2);
