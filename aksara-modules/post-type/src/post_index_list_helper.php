<?php

/*
 * Filter Status based on post_status parameter
 */
function post_type_index_filter_args_post_status($args)
{
    $args['post_status'] = \Request::input('post_status');

    return $args;
}

/*
 * Filter without trash post on ALL
 */
function post_type_index_filter_post_status($posts)
{
    if (!Request::input('post_status')) {
        $posts->addQuery(function($query){
            return  $query->where('post_status', '<>', 'trash');
        });
    }

    return $posts;
}

/*
 * Custom view data
 */
function post_type_index_custom_view_dat($args)
{
    extract($args);

    $postsCount = clone $posts;

    $viewData['total'] = $postsCount->count();

    if (\Request::input('post_status')) {
        $viewData['post_status'] = \Request::input('post_status');
    } else {
        $viewData['post_status'] = '';
    }

    if (\Request::input('search')) {
        $viewData['search'] = \Request::input('search');
    } else {
        $viewData['search'] = '';
    }

    return compact('posts', 'viewData');
}

/*
 * Custom alphaordering when post_type == page
 */
function post_type_index_filter_ordering($posts)
{
    if (get_current_post_type() == 'page') {
        $posts->addQuery(function($query){
            return  $query->orderBy('post_title', 'asc');
        });
    } else {
        $posts->addQuery(function($query){
            return  $query->orderBy('post_date', 'desc');
        });
    }

    return $posts;
}

/*
 * Search filter query
 */
function post_type_index_filter_search($posts)
{
    if (\Request::input('search')) {
        $posts->addQuery(function($query){
            return  $query->where('post_title', 'LIKE', '%'.\Request::input('search').'%');
        });
    }

    return $posts;
}


/*
 * Taxonomy filter
 */
function post_type_index_filter_filter_taxonomy($posts)
{
    // get all taxonomy for post type
    $taxonomies = get_taxonomies(get_current_post_type());
    foreach ($taxonomies as $taxonomy) {
        $searchTerm = \Request::input('taxonomy.'.$taxonomy['id']);

        if (!$searchTerm) {
            continue;
        }

        $term = get_term($taxonomy['id'], $searchTerm);

        if (!$term) {
            continue;
        }

        $posts->addQuery(function($query) use ($term) {
            return $query->whereHas('term_relations', function ($query) use ($term) {
                $query->where('term_id', '=', $term->id);
            });
        });

    }

    return $posts;
}

