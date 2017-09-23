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
                $postTerm = TermRelationship::where('post_id', $postID)->whereIn('term_id', $term);
                //Checking post term data
                if ($postTerm->count())
                {
                    // Delete post term data if data valid
                    if(!$postTerm->delete())
                        return FALSE;
                } else {
                    return FALSE;
                }
            } else {
                //Get post term data
                $postTerm = TermRelationship::where('post_id', $postID);
                //Checking post term data
                if ($postTerm->count())
                {
                    // Delete post term data if data valid
                    if(!$postTerm->delete())
                        return FALSE;
                } else {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    // Function for get post term data
    public static function getPostTerms($postID = false, $taxonomy = false, $arg = false)
    {
        // Checking post_id data can't be empty
        if (!$postID)
        {
            return collect([]);
        } else {
            // Checking post data
            $post = Post::find($postID);
            if (!$post)
                return collect([]);
        }

        // Checking post_id data can't be empty
        if (!$taxonomy)
        {
            return collect([]);
        } else {
            // Checking taxonomy data
            $dtaxonomy = Taxonomy::where('taxonomy_name', $taxonomy)->first();
            if (!$dtaxonomy)
                return collect([]);
        }

        // Start get post term data from db
        $postTerm = TermRelationship::where('post_id', $postID)->where('terms.taxonomy_id', $dtaxonomy->id);
        $postTerm = $postTerm->join('terms', 'terms.id', '=', 'term_relationships.term_id');
        // Checking arg data
        if ($arg)
        {
            // Checking arg data if not in array type
            if(!is_array($arg))
                return collect([]);

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
                            return collect([]);
                        break;
                    case 'order':
                        $order = $v;
                        break;
                    case 'child':
                        if(!((boolean)$v))
                            $postTerm = $postTerm->where('terms.parent', '=', 0);
                        break;
                }

            }
            $postTerm = $postTerm->select('term_relationships.*')->orderBy('terms.'.$orderby, $order)->get();
        } else {
            $postTerm = $postTerm->select('term_relationships.*')->get();
        }
        return $postTerm;
    }

    // Function for set post term data
    public static function set_post_term($postID = false, $taxonomy = false, $terms = false)
    {
        // Checking post_id data can't be empty
        if (!$postID)
            throw new \Exception('Post ID not set');
        else
        {
            // Checking post data
            $post = Post::find($postID);
            if (!$post)
                throw new \Exception('Post with ID = '.$postID.' not exist');
        }

        // Checking taxonomy data can't be empty
        if (!$taxonomy)
            throw new \Exception('Taxonomy not set');
        else
        {
            // Checking taxonomy
            $dtaxonomy = Taxonomy::where('taxonomy_name', $taxonomy)->first();
            if (!$dtaxonomy)
                throw new \Exception('Taxonomy name '.$taxonomyName.' not found');
        }

        // Checking term data can't be empty
        if ( !$terms )
            throw new \Exception('Term(s) not set');

        if( !is_array($terms) )
            $terms = [$terms];

        foreach ($terms as $term )
        {
            // Checking term if interger type
            if(is_integer($terms))
                $dterm = Term::find($term);
            else
                $dterm = Term::where('taxonomy_id', $dtaxonomy->id)->where('id', $term)->first();

            // Checking term data valid or invalid
            if (!$dterm)
                throw new \Exception('Term name '.$term->name.' not found on taxonomy ',$taxonomy->taxonomy_name);

            $postTerm = TermRelationship::where('post_id', $postID)->where('term_id', $dterm->id)->first();

            if($postTerm)
                continue;

            $postTerm = new TermRelationship;
            $postTerm->term_id = $dterm->id;
            $postTerm->post_id = $postID;
            $postTerm->save();
        }
    }

}
