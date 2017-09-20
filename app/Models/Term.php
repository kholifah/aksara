<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model 
{

    protected $table = 'terms';
    protected $fillable = ['taxonomy_id', 'name', 'slug', 'parent'];
    public $timestamps = false;

    public function validate($data) 
    {
        $rules = [
            'taxonomy_id' => 'required',           
            'name' => 'required',
            'slug' => 'required',
        ];

        return \Validator::make($data, $rules);
    }
    
    public function term_parent() 
    {
        return $this->belongsTo('App\Models\Term', 'parent');
    }

    public function taxomony() 
    {
        return $this->belongsTo('App\Models\Taxonomy', 'taxomony_id');
    }
    
    public function term_relations() 
    {
        return $this->hasMany('App\Models\TermRelationship', 'term_id');
    }
    
    public static function delete_term($termID = false) 
    {
        //Checking term_id data can't be empty     
        if (!$termID) 
        {
            return FALSE;
        } else {
            //Checking term data       
            $term = Term::find($termID);  
            if ($term)
            {             
                // Delete term data if data valid                 
                if(!$term->delete())              
                    return FALSE;
            } else {
                return FALSE;
            }
        }
        return TRUE;
    }

    // Function for get term data
    public static function get_term($taxonomy = false, $arg = false) 
    {
        // Checking post_id data can't be empty 
        if (!$taxonomy) 
        {
            return FALSE;
        } else {
            // Checking post data
            $dtaxonomy = Taxonomy::where('taxonomy_name', $taxonomy)->get();
            if($dtaxonomy->count() > 1)
                $dtaxonomy = Taxonomy::where('post_type', get_current_post_type())->where('taxonomy_name', $taxonomy)->first();            
            if (!$dtaxonomy)
                return FALSE;
        }
       
        if(isset($dtaxonomy[0]))
        {
            $term = Term::where('taxonomy_id', $dtaxonomy[0]->id);
        } else {
            // Get term data from db
            $term = Term::where('taxonomy_id', $dtaxonomy->id);
        }
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
                $paginate = 10;
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
                            $term = $term->where('parent', '=', 0);
                        break;
                    case 'paginate':
                        $paginate = (int)$v;
                        break;
                }

            }


            $term =  $term->orderBy($orderby, $order)->paginate($paginate);
        } else {
            $term = $term->orderBy('parent')->get();
        }
        return $term;
    }

    // Function for add term data
    public static function add_term($taxonomy = false, $name= false, $slug = false, $parent = false) 
    {
        // Checking taxonomy data can't be empty 
        if (!$taxonomy) 
        {
            return FALSE;
        } else {
            // Checking taxonomy
            $dtaxonomy = Taxonomy::where('post_type', get_current_post_type())->where('taxonomy_name', $taxonomy)->first();
            
            if (!$dtaxonomy)
            {
                admin_notice('danger', 'Data '.$taxonomy.' tidak valid!');     
                return FALSE;        
            }

        }
        
        // Checking name data can't be empty 
        if (!$name)
        {
            admin_notice('danger', 'Bidang isian judul wajib diisi.');        
            return FALSE;
        }  

        // Checking slug data can't be empty 
        if (!$slug)
        {
            admin_notice('danger', 'Bidang isian judul wajib diisi.'); 
            return FALSE;
        } else {
            // Checking slug mush be unique group by taxonomy type
            $sterm = Term::where('taxonomy_id', $dtaxonomy->id)->where('slug', $slug)->first();
            if($sterm)
                return FALSE;
        }

         // Checking parent data if data null or empty
        if (!$parent)
        {
            $parent = 0;
        } else {
            // Get term parent with make sure parent data integer
            $cterm = Term::find((int)$parent);
            // Checking term parent valid or invalid
            if($cterm)
            {
                // Checking term parent in same taxomony
                if($cterm->taxonomy_id != $dtaxonomy->id)
                {
                    return FALSE;
                } 
            } else {
                return FALSE;
            }
        } 

        // Data input
        $save = [
            'taxonomy_id' => (int)$dtaxonomy->id,
            'name' => $name,
            'slug' => $slug,
            'parent' => (int)$parent
        ];   

        $term = new Term;
        // Checking data input
        $validator = $term->validate($save);
        if ($validator->fails()) 
        {            
            foreach ($validator->messages()->toArray() as $v) {                
                admin_notice('danger', $v[0]);
            }
            return FALSE;
        }
        $term->taxonomy_id = $save['taxonomy_id'];
        $term->name = $save['name'];
        $term->slug = $save['slug'];
        $term->parent = $save['parent'];
        // Create new data 
        if ($term->save())
            return TRUE;
        else
            return false;

    }


    // Function for update term data
    public static function update_term($termID = false, $name= false, $slug = false, $parent = false) 
    {
        // Checking term_id data can't be empty 
        if (!$termID) 
        {
            return FALSE;
        } else {            
                // Get term data
                $term = Term::find($termID);
                //Checking term data valid or invalid
                if(!$term)
                    return FALSE;
        }

        // Checking name data can't be empty 
        if (!$name)
        {
            admin_notice('danger', 'Judul is required.');
            return FALSE;
        }  

        // Checking slug data can't be empty 
        if (!$slug)
        {
            admin_notice('danger', 'Judul is required.');
            return FALSE;
        } else {
            // Checking slug mush be unique group by taxonomy type
            $sterm = Term::where('taxonomy_id', $term->taxonomy_id)->where('slug', $slug)->where('id', '<>', $termID)->first();
            if($sterm)
                return FALSE;
        } 

         // Checking parent data if data null or empty
        if (!$parent)
        {
            $parent = 0;
        } else {
            // Get term parent and make sure parent data integer
            $cterm = Term::find((int)$parent);
            // Checking term parent valid or invalid
            if($cterm)
            {
                // Checking term parent in same taxomony
                if($cterm->taxonomy_id != $term->taxonomy_id)
                {
                    return FALSE;
                } 
            } else {
                return FALSE;
            }
        } 
        // Data input
        $save = [       
            'taxonomy_id' => $term->taxonomy_id,
            'name' => $name,
            'slug' => $slug,
            'parent' => (int)$parent
        ];   

        // Checking data input
        $validator = $term->validate($save);
        if ($validator->fails()) 
        {
            foreach ($validator->messages()->toArray() as $v) {                
                admin_notice('danger', $v[0]);
            }
            return FALSE;
        }
        $term->taxonomy_id = $save['taxonomy_id'];
        $term->name = $save['name'];
        $term->slug = $save['slug'];
        $term->parent = $save['parent'];
        // Update new data 
        if ($term->save())
            return TRUE;
        else
            return false;
    }


    

}
