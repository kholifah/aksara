<?php

namespace App\Models;

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
    public static function get_taxonomy() 
    {    
        // Checking post data
        $taxonomy = Taxonomy::get();
        if (!$taxonomy)
            return FALSE;

        return $taxonomy;
    }
    
    // Function for check term data
    public static function check_taxonomy($postType, $taxonomy) 
    {    
        if(is_array($postType))
        {
            foreach ($postType as $v) 
            {
                $taxo = Taxonomy::where('post_type', $v)->where('taxonomy_name', $taxonomy)->first();
                if (!$taxo)
                {
                    $taxo = new Taxonomy;
                    $taxo->post_type = $v;
                    $taxo->taxonomy_name = $taxonomy;
                    $taxo->slug = str_slug($taxonomy,'-');
                    $taxo->save();
                } else {
                    $taxo->post_type = $v;
                    $taxo->taxonomy_name = $taxonomy;
                    $taxo->slug = str_slug($taxonomy,'-');
                    $taxo->save();
                }
            }
            //Taxonomy::whereNotIn('post_type', $postType)->where('taxonomy_name', $taxonomy)->delete();
            return TRUE;
        }
        return FALSE;
    }

}
