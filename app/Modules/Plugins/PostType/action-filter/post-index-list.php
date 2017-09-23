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
        $viewData['search'] = \Request::input('search');
        $posts = $posts->where('post_title', 'LIKE', '%'.$viewData['search'].'%');
    } else {
        $viewData['search'] = '';
    }

    return compact('posts','viewData');
}

function post_type_index_filter_post_status($args)
{
    extract($args);

    if (\Request::input('post_status'))
    {
        $viewData['post_status'] = \Request::input('post_status');
        $posts = $posts->where('post_status', $viewData['post_status']);
    } else {
        $viewData['post_status'] = '';
        $posts = $posts->where('post_status', '<>', 'trash');
    }

    return compact('posts','viewData');
}

function post_type_index_filter_filter_taxonomy($args)
{
    extract($args);

    // get all taxonomy for post type
    $taxonomies = get_taxonomies(get_current_post_type());
    foreach ( $taxonomies as $taxonomy )
    {
        $searchTerm = \Request::input('taxonomy.'.$taxonomy['id'] );

        if( !$searchTerm )
            continue;

        $term = get_term($taxonomy['id'],$searchTerm);

        if( !$term )
            continue;

        $posts = $posts->whereHas('term_relations',function($query) use ($term){
            $query->where('term_id','=',$term->id);
        });
    }

    return compact('posts','viewData');
}
