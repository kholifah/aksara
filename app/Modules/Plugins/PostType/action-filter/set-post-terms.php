<?php
// modify post ordering
\Eventy::addAction('aksara.init', function () {
    $postTypes = \Config::get('aksara.post_type');
    $postTypes = array_keys($postTypes);

    foreach ($postTypes as $postType) {
        \Eventy::addAction('aksara.post-type.'.$postType.'.create', 'post_type_set_post_terms', 20, 2);
        \Eventy::addAction('aksara.post-type.'.$postType.'.update', 'post_type_set_post_terms', 20, 2);
    }
}, 90);
//        set_post_meta($post->id, 'post_content', $data['post_content'], false);
//        set_post_meta($post->id, 'post_slug', $data['slug'], false);

function post_type_set_post_terms($post, $request)
{
    $taxonomies = get_taxonomies(get_current_post_type());

    foreach ($taxonomies as $taxonomy) {
        $termIds = $request->input('taxonomy.'.$taxonomy['id']);

        // set
        if ($termIds) {
            set_post_terms($post->id, $taxonomy['id'], $termIds);
        }

        // delete
        $deletedTerms = \App\Modules\Plugins\PostType\Model\TermRelationship::where('post_id', $post->id)
                                                                ->whereHas('term', function ($query) use ($taxonomy) {
                                                                    $query->whereHas('taxonomy', function ($query) use ($taxonomy) {
                                                                        $query->where('taxonomy_name', $taxonomy['id']);
                                                                    });
                                                                });

        if ($termIds) {
            $deletedTerms = $deletedTerms->whereNotIn('term_id', $termIds);
        }

        $deletedTerms->delete();
    }
}
