<?php
// modify post ordering

function post_type_base_column($cols, $postType)
{
    $cols['quick-edit'] = ['title'=>'','width'=>'20px','class'=>'no-sort'];
    $cols['title'] = ['title'=> __('post-type::default.title') ];
    $cols['status'] = ['title'=> __('post-type::default.status'),'width'=>'100px'];

    return $cols;
}

function post_type_base_row($colsId, $post)
{
    if ($colsId == 'quick-edit') {
        echo view('post-type::partials.table-row-quick-edit', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'title') {
        echo view('post-type::partials.table-row-title', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'status') {
        echo view('post-type::partials.table-row-status', compact('colsId', 'post'))->render();
    }
    if ($colsId == 'edit') {
        echo view('post-type::partials.table-row-edit', compact('colsId', 'post'))->render();
    }
}

function post_type_image_column($cols, $postType)
{
    unset($cols['title']);
    unset($cols['status']);

    $imageCol = [
        'image' => ['title'=>__('post-type::default.image'),'width'=>'200px','class'=>'image no-sort']
    ];

    insert_after_array_key($cols, 'quick-edit', $imageCol);

    return $cols;
}

function post_type_image_row($colsId, $post)
{
    if ($colsId == 'image') {
        echo view('post-type::partials.table-row-image', compact('colsId', 'post'))->render();
    }
}

function post_type_tag_category_column($cols, $postType)
{
    $taxonomyCol = [
        'category' => ['title'=>__('post-type::default.category'),'width'=>'150px'],
        'tag' => ['title'=>__('post-type::default.tag'),'width'=>'150px']
    ];

    insert_after_array_key($cols, 'title', $taxonomyCol);

    return $cols;
}

function post_type_tag_category_row($colsId, $post)
{
    if ($colsId == 'tag' || $colsId == 'category') {
        $terms = get_post_terms($post->id, $colsId);

        if (!$terms) {
            return;
        }

        $terms = $terms->pluck('term.name')->toArray();

        echo view('post-type::partials.table-row-post-category-tag', compact('terms'))->render();
    }
}

