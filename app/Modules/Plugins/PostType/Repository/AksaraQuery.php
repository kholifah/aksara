<?php
namespace App\Modules\Plugins\PostType\Repository;
use App\Modules\Plugins\PostType\Model\Post as Post;

class AksaraQuery
{
    private $args = [];

    public function __construct($args=[])
    {
        // bisa dimodifikasi di aksara.post-type.front-end.aksara-query-args
        // $defaultArgs = [
        //     'post_type' => $postType // and where
        //     'post_status' => $status // and where
        //     'post_slug' => $status // and where
        //     'post_id' => $status // and where
        //     'author_id' => $id / $ids[] // and where
        //     'author_slug'=> $authorSlug / $authorSlugs [] // and where @
        //     'taxonomy'=> $taxonomy and where @
        //     'category_id'=> $category_id / $category_ids[] // and where
        //     'category_slug'=> $category_id / $category_ids[] // and where
        //     'tag_id' => $tag_id / $tag_ids // and weere
        //     'tag_slug' => $tag_id / $tag_ids // and weere
        //     'taxonomy_query'=> [
        //         ['and',[
        //             'taxonomy' => 'color',                //(string) - Taxonomy.
        //             'field' => 'slug',                    //(string) - Select taxonomy term by ('id' or 'slug')
        //             'terms' => array( 'red', 'blue' ),
        //             'include_children' => true              // bolean
        //             ]
        //         ],
        //         ['and',[
        //             'taxonomy' => 'color',                //(string) - Taxonomy.
        //             'field' => 'slug',                    //(string) - Select taxonomy term by ('id' or 'slug')
        //             'terms' => array( 'red', 'blue' ),
        //             ]
        //         ],
        //     ]
        //     'page' => $page // page
        //     'post_per_page'=> $num,
        //     'orderby' => $field,
        //     'order' => 'desc'/'asc',
        //     'search' => $searchQuery
        // ]
        $defaultArgs = [
            'post_type' => 'post',
            'post_status' => 'publish',
            'page' => 1,
            'post_per_page'=> 10,
            'order_by' => 'post_date',
            'order' => 'desc'
        ];
        // modifikasi lanjutan pada aksara.post-type.front-end.aksara-query-pre-get-post
        $this->args = array_merge($defaultArgs, $args);

        // Validation
        $this->args['page'] = intval($this->args['page']);
        $this->args['post_per_page'] = intval($this->args['post_per_page']);
    }

    function getQuery()
    {
        $post = new Post();

        if( isset($this->args['post_type']) && $this->args['post_type'] !== false ) {
            if( ( $this->args['post_type'] == 'post' || $this->args['post_type'] == 'page') && isset($this->args['post_slug']) ) {
                $post = $post->orWhereIn('post_type',['post','page']);
            }
            else  {
                $post = $post->where('post_type',$this->args['post_type']);
            }
        }

        if( isset($this->args['post_status']) ) {
            $post = $post->where('post_status',$this->args['post_status']);
        }

        if( isset($this->args['post_slug']) ) {
            $post = $post->where('post_slug',$this->args['post_slug']);
        }

        if( isset($this->args['post_id']) ) {
            $post = $post->where('post_id',$this->args['post_slug']);
        }

        if( isset($this->args['author_id']) ) {
            $post = $post->where('post_author',$this->args['author_id']);
        }

        if( isset($this->args['author_slug']) ) {
            //TODO
        }

        if( isset($this->args['order_by']) ) {
            $order = $this->args['order'] ? $this->args['order'] : 'desc';
            $post = $post->orderBy($this->args['order_by'],$order);
        }

        $taxonomyQueries = [];

        if( isset($this->args['category_id']) ) {

            $categoryIDs = $this->args['category_id'];
            $taxonomyQuery = [
                'and' => [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $categoryIDs,
                    'include_children' => true
                ]
            ];
            array_push($taxonomyQueries , $taxonomyQuery);
        }

        if( isset($this->args['category_slug']) ) {

            $categorySlugs = $this->args['category_slug'];
            $taxonomyQuery = [
                'and'=>[
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $categorySlugs,
                    'include_children' => true
                ]
            ];
            array_push($taxonomyQueries , $taxonomyQuery);
        }

        if( isset($this->args['tag_id']) ) {

            $tagIDs = $this->args['tag_id'];
            $taxonomyQuery = [
                'and'=>[
                    'taxonomy' => 'tag',
                    'field' => 'id',
                    'terms' => $tagIDs,
                    'include_children' => true
                ]
            ];
            array_push($taxonomyQueries , $taxonomyQuery);
        }

        if( isset($this->args['tag_slug']) ) {

            $tagSlugs = $this->args['tag_slug'];
            $taxonomyQuery = [
                'and'=>[
                    'taxonomy' => 'tag',
                    'field' => 'slug',
                    'terms' => $tagSlugs,
                    'include_children' => true
                ]
            ];
            array_push($taxonomyQueries , $taxonomyQuery);
        }

        if( isset($this->args['taxonomy']) ) {

            $taxonomyQuery = [
                'and'=>[
                    'taxonomy' => $this->args['taxonomy'],
                    'include_children' => true
                ]
            ];
            array_push($taxonomyQueries , $taxonomyQuery);
        }

        if( isset($this->args['taxonomy_query']) ) {
            foreach ($this->args['taxonomy_query'] as $operator => $taxonomyQuery) {
                array_push($taxonomyQueries , [$operator =>$taxonomyQuery]);
            }
        }

        if( sizeof($taxonomyQueries) > 0 ) {
            $post = $post->where(function($query) use ($taxonomyQueries) {
                foreach ($taxonomyQueries as $taxonomyQuery ) {
                    $operator = key($taxonomyQuery);
                    $operator = strtolower($operator);
                    $operator = $operator === 'and' ? 'whereHas' : 'orWhereHas';

                    $taxonomyQuery = $taxonomyQuery[key($taxonomyQuery)];

                    // Join TermRelation
                    $query->$operator('term_relations',function($query) use ($taxonomyQuery){
                        // Join Term
                        $query->whereHas('term',function($query) use ($taxonomyQuery){
                            if( isset($taxonomyQuery['terms']) && isset($taxonomyQuery['field']) ) {

                                $taxonomyQuery['terms'] = is_array($taxonomyQuery['terms']) ? $taxonomyQuery['terms'] : [$taxonomyQuery['terms']];
                                $query->whereIn($taxonomyQuery['field'],$taxonomyQuery['terms']);
                            }
                            // Join Taxonomy
                            $query->whereHas('taxonomy',function($query) use ($taxonomyQuery){
                                $query->where('taxonomy_name',$taxonomyQuery['taxonomy']);
                            });
                        });
                    });
                }
            });
        }

        // Pagination
        $take = isset($this->args['post_per_page']) ? $this->args['post_per_page'] : 10 ;
        $page = isset($this->args['page']) ? $this->args['page'] : 1 ;
        $skip = ($page- 1)*$take ;

        if( isset($this->args['page']) && isset($this->args['post_per_page']) ) {
            $post = $post->take($take)->skip($skip);
        }



        return $post;
    }
}
