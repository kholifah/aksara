<?php

namespace App\Modules\Plugins\PostType\Model;

use Illuminate\Database\Eloquent\Model;
use \App\Modules\Plugins\PostType\Model\Post;

class TermRelationship extends Model
{

    protected $table = 'term_relationships';
    protected $fillable = ['term_id', 'post_id'];
    public $timestamps = false;

    public function validate($data)
    {
        $rules = [
            'term_id' => 'required',
            'post_id' => 'required',
        ];

        return \Validator::make($data, $rules);
    }

    public function term()
    {
        return $this->belongsTo('App\Modules\Plugins\PostType\Model\Term', 'term_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Modules\Plugins\PostType\Model\Post', 'post_id');
    }

    public static function delete_post_term($postID = false, $taxonomy = false)
    {
        //Checking post_id n taxonomy data can't be empty
        if (!$postID)
        {
            return FALSE;
        } else {
            // Check if taxonomy = empty
            if($taxonomy)
            {
                // Get taxonomy data
                $dtaxonomy = Taxonomy::where('post_type', get_current_post_type())->where('taxonomy_name', $taxonomy)->first();
                // Check taxonomy data
                if(!$dtaxonomy)
                    return FALSE;

                // Get term id by taxomomy id
                $term = Term::where('taxonomy_id', $dtaxonomy->id)->lists('id');
                // Checking list term id by taxonomy
                if(!count($term))
                    return FALSE;
                //Get post term data
                $postterm = TermRelationship::where('post_id', $postID)->whereIn('term_id', $term);
                //Checking post term data
                if ($postterm->count())
                {
                    // Delete post term data if data valid
                    if(!$postterm->delete())
                        return FALSE;
                } else {
                    return FALSE;
                }
            } else {
                //Get post term data
                $postterm = TermRelationship::where('post_id', $postID);
                //Checking post term data
                if ($postterm->count())
                {
                    // Delete post term data if data valid
                    if(!$postterm->delete())
                        return FALSE;
                } else {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    // Function for get post term data
    public static function get_post_term($postID = false, $taxonomy = false, $arg = false)
    {
        // Checking post_id data can't be empty
        if (!$postID)
        {
            return FALSE;
        } else {
            // Checking post data
            $post = Post::find($postID);
            if (!$post)
                return FALSE;
        }

        // Checking post_id data can't be empty
        if (!$taxonomy)
        {
            return FALSE;
        } else {
            // Checking taxonomy data
            $dtaxonomy = Taxonomy::where('post_type', get_current_post_type())->where('taxonomy_name', $taxonomy)->first();
            if (!$dtaxonomy)
                return FALSE;
        }


        // Start get post term data from db
        $postterm = TermRelationship::where('post_id', $postID)->where('terms.taxonomy_id', $dtaxonomy->id);
        $postterm = $postterm->join('terms', 'terms.id', '=', 'term_relationships.term_id');
        // Checking arg data
        if ($arg)
        {
            // Checking arg data if not in array type
            if(!is_array($arg))
                return FALSE;

            foreach ($arg as $k => $v)
            {
                $orderby = 'id';
                $order = 'ASC';
                switch ($k)
                {
                    case 'order_by':
                        $model = new Term;
                        $fillable = $model->getFillable();
                        // Checking field name
                        if(in_array($v, $fillable))
                            $orderby = $v;
                        else
                            return FALSE;
                        break;
                    case 'order':
                        $order = $v;
                        break;
                    case 'child':
                        if(!((boolean)$v))
                            $postterm = $postterm->where('terms.parent', '=', 0);
                        break;
                }

            }
            $postterm = $postterm->select('term_relationships.*')->orderBy('terms.'.$orderby, $order)->get();
        } else {
            $postterm = $postterm->select('term_relationships.*')->get();
        }
        return $postterm;
    }

    // Function for set post term data
    public static function set_post_term($postID = false, $taxonomy = false, $term = false)
    {
        // Checking post_id data can't be empty
        if (!$postID)
        {
            return FALSE;
        } else {
            // Checking post data
            $post = Post::find($postID);
            if (!$post)
                return FALSE;
        }

        // Checking taxonomy data can't be empty
        if (!$taxonomy)
        {
            return FALSE;
        } else {
            // Checking taxonomy
            $dtaxonomy = Taxonomy::where('post_type', get_current_post_type())->where('taxonomy_name', $taxonomy)->first();
            if (!$dtaxonomy)
                return FALSE;
        }

        // Checking term data can't be empty
        if (!$term)
        {
            return FALSE;
        } else {
            // Checking term if interger type
            if(is_integer($term))
                $dterm = Term::find($term);
            else
                $dterm = Term::where('taxonomy_id', $dtaxonomy->id)->where('slug', $term)->first();
            // Checking term data valid or invalid
            if (!$dterm)
                return FALSE;
        }

        // Data input
        $save = [
            'term_id' => (int)$dterm->id,
            'post_id' => (int)$postID,
        ];

        $postterm = TermRelationship::where('post_id', $postID)->where('term_id', $dterm->id)->first();

        if(!$postterm)
        {
            $postterm = new TermRelationship;
            // Checking data input
            $validator = $postterm->validate($save);
            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }
            $postterm->term_id = $save['term_id'];
            $postterm->post_id = $save['post_id'];

            // Create new data
            if ($postterm->save())
                return TRUE;
            else
                return false;
        }

    }

}
