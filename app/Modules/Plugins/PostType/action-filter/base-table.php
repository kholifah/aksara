<?php
// modify post ordering
\Eventy::addAction('aksara.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');

    foreach ($postTypes as $postType => $args) {
        \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column', 'post_type_base_column', 1, 2);
        \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row', 'post_type_base_row', 1, 2);
    }
});

function post_type_base_column($cols, $postType)
{
    $cols['quick-edit'] = ['title'=>'','width'=>'20px','class'=>'no-sort'];
    $cols['title'] = ['title'=>'Judul'];
    $cols['status'] = ['title'=>'Status','width'=>'100px'];
    $cols['edit'] = ['title'=>'Edit','width'=>'125px','class'=>'no-sort'];

    return $cols;
}

function post_type_base_row($colsId, $post)
{
    if ($colsId == 'quick-edit') {
        echo view('plugin:post-type::partials.table-row-quick-edit', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'title') {
        echo view('plugin:post-type::partials.table-row-title', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'status') {
        echo view('plugin:post-type::partials.table-row-status', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'edit') {
        echo view('plugin:post-type::partials.table-row-edit', compact('colsId', 'post'))->render();
    }
}

function post_type_image_column($cols, $postType)
{
    unset($cols['title']);
    unset($cols['status']);

    $imageCol = [
        'image' => ['title'=>'Image','width'=>'200px','class'=>'image no-sort']
    ];

    insert_after_array_key($cols, 'quick-edit', $imageCol);

    return $cols;
}
\Eventy::addFilter('aksara.post-type.media.index.table.column', 'post_type_image_column', 20, 2);

function post_type_image_row($colsId, $post)
{
    if ($colsId == 'image') {
        echo view('plugin:post-type::partials.table-row-image', compact('colsId', 'post'))->render();
    }
}
\Eventy::addAction('aksara.post-type.media.index.table.row', 'post_type_image_row', 1, 2);

function post_type_tag_category_column($cols, $postType)
{
    $taxonomyCol = [
        'category' => ['title'=>'Category','width'=>'150px'],
        'tag' => ['title'=>'tag','width'=>'150px']
    ];

    insert_after_array_key($cols, 'title', $taxonomyCol);

    return $cols;
}
\Eventy::addFilter('aksara.post-type.post.index.table.column', 'post_type_tag_category_column', 20, 2);

function post_type_tag_category_row($colsId, $post)
{
    if ($colsId == 'tag' || $colsId == 'category') {
        $terms = get_post_terms($post->id, $colsId);


        if (!$terms) {
            return;
        }

        $terms = $terms->pluck('term.name')->toArray();

        echo view('plugin:post-type::partials.table-row-post-category-tag', compact('terms'))->render();
    }
}
\Eventy::addAction('aksara.post-type.post.index.table.row', 'post_type_tag_category_row', 1, 2);
