<?php
namespace App\Modules\Plugins\PostType\Repository;

use App\Modules\Plugins\PostType\Model\Term;
use Auth;

class TaxonomyRepository implements TaxonomyRepositoryInterface
{

    // protected $post_type;

    public function __construct()
    {
        // $this->post_type = get_current_post_type();
    }

    // public function getSlug($data, $id = FALSE)
    // {
    //     $term = Term::where('terms.slug', $data);
    //     if( $this->post_type )
    //     {
    //         $term = $term->join('taxonomies', 'taxonomies.id', '=', 'terms.taxonomy_id');
    //     }
    //
    //     if( $id )
    //         $term = $term->where('terms.id', '<>', $id);
    //
    //     if($term->count())
    //     {
    //         $slug = $this->set_slug($data);
    //         $data = $this->getSlug($slug, $id);
    //     } else {
    //         $data = $data;
    //     }
    //     return $data;
    // }
    //
    // public function set_slug($data)
    // {
    //     if (strpos($data, '-') !== false)
    //         $s = explode('-', $data);
    //     else
    //         $s = [$data];
    //     $last = (int)$s[(count($s) - 1)];
    //     if($last)
    //     {
    //         $slug = '';
    //         for($i = 0; $i < count($s); $i++)
    //         {
    //             if($i == 0)
    //                 $slug = $s[$i];
    //             else if($i == (count($s)-1))
    //                 $slug = $slug.'-'.($last + 1);
    //             else
    //                 $slug = $slug.'-'.$s[$i];
    //         }
    //     } else {
    //         $slug = $data.'-1';
    //     }
    //     return $slug;
    // }
}
