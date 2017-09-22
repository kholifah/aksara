<?php
namespace App\Modules\Plugins\PostType\Model;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{

    protected $table = 'taxonomies';
    protected $fillable = ['post_type', 'taxonomy_name', 'slug'];
    public $timestamps = false;

    public function validate($data)
    {
        $rules = [
            'post_type' => 'required|max:20',
            'taxonomy_name' => 'required|max:40',
            'slug' => 'required',
        ];

        return \Validator::make($data, $rules);
    }

    // Function for get term data
    public static function getTaxonomies( $postType )
    {
        // Checking post data
        if( !$postType )
            $taxonomy = Taxonomy::get();
        else
            $taxonomy = Taxonomy::where('post_type',$postType)->get();

        if (!$taxonomy)
            return FALSE;

        return $taxonomy;
    }

    // Persist taxonomy
    public static function persistTaxonomy($taxonomyName)
    {
        $taxonomy = Taxonomy::where('taxonomy_name', $taxonomyName)->first();

        if (!$taxonomy)
        {
            $taxonomy = new Taxonomy;
            $taxonomy->taxonomy_name = $taxonomyName;
            $taxonomy->slug = str_slug($taxonomyName);
            $taxonomy->save();
        }
    }

}
