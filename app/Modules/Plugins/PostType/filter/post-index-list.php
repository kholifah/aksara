<?php
// modify post ordering
\Eventy::addAction('aksara.init',function(){

    $postTypes = \Config::get('aksara.post_type');
    $postTypes = array_keys($postTypes);

    foreach ($postTypes as $postType) {
        \Eventy::addfilter('aksara.post-type.'.$postType.'.index.pre-get-post','post_type_index_filter_ordering');
        \Eventy::addfilter('aksara.post-type.'.$postType.'.index.pre-get-post','post_type_index_filter_search');
        \Eventy::addfilter('aksara.post-type.'.$postType.'.index.pre-get-post','post_type_index_filter_filter_taxonomy');
        \Eventy::addfilter('aksara.post-type.'.$postType.'.index.pre-get-post','post_type_index_filter_post_status');
    }
},90);

function post_type_index_filter_ordering($args)
{
    extract($args);

    if( get_current_post_type() == 'page' )
        $posts = $posts->orderBy('post_title','asc');
    else
        $posts = $posts->orderBy('post_date','desc');

    return compact('posts','args');
}

function post_type_index_filter_search($args)
{
    extract($args);
    // $posts = $posts->where('post_type', $taxo);
    if (\Request::input('search'))
    {
        $postsQueryArgs['search'] = \Request::input('search');
        $posts = $posts->where('post_title', 'LIKE', '%'.$postsQueryArgs['search'].'%');
    } else {
        $postsQueryArgs['search'] = '';
    }

    return compact('posts','postsQueryArgs');
}

function post_type_index_filter_post_status($args)
{
    extract($args);

    if (\Request::input('post_status'))
    {
        $postsQueryArgs['post_status'] = \Request::input('post_status');
        $posts = $posts->where('post_status', $postsQueryArgs['post_status']);
    } else {
        $postsQueryArgs['post_status'] = '';
        $posts = $posts->where('post_status', '<>', 'trash');
    }

    return compact('posts','postsQueryArgs');
}

function post_type_index_filter_filter_taxonomy($args)
{
    extract($args);

    if (\Request::input('category'))
    {
        $postsQueryArgs['category'] = \Request::input('category');
        $posts = $posts->join('term_relationships', 'term_relationships.post_id', '=', 'posts.id');
        $posts = $posts->where('term_id', $postsQueryArgs['category'])->groupBy('posts.id');
    } else {
        $postsQueryArgs['category'] = '';
    }

    return compact('posts','postsQueryArgs');
}
