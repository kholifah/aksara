<?php

namespace Plugins\PostType\Model;

use Illuminate\Database\Eloquent\Model;
use Plugins\PostType\Model\Post;

class Term extends Model
{
    protected $table = 'terms';
    protected $fillable = ['taxonomy_id', 'name', 'slug', 'parent'];
    public $timestamps = false;

    public static function getTerm($taxonomy, $arg)
    {
        if (!$taxonomy) {
            throw new \Exception('Taxonomy with name : "'.$taxonomy.'" not found');
        }

        $term = Term::whereHas('taxonomy', function ($query) use ($taxonomy) {
            $query->where('taxonomy_name', '=', $taxonomy);
        });

        if ((int) $arg) {
            $term = $term->where('id', $arg);
        } elseif ($args) {
            $term = $term->where('name', $arg);
        }

        return $term->first();
    }

    public function validate($data)
    {
        $rules = [
            'taxonomy_id' => 'required',
            'name' => 'required'
        ];

        return \Validator::make($data, $rules);
    }

    public function term_parent()
    {
        return $this->belongsTo('Plugins\PostType\Model\Term', 'parent');
    }

    public function taxonomy()
    {
        return $this->belongsTo('Plugins\PostType\Model\Taxonomy', 'taxonomy_id');
    }

    public function term_relations()
    {
        return $this->hasMany('Plugins\PostType\Model\TermRelationship', 'term_id');
    }

    public static function deleteTerm($termID = false)
    {
        //Checking term_id data can't be empty
        if (!$termID) {
            return false;
        } else {
            //Checking term data
            $term = Term::find($termID);
            if ($term) {
                // Delete term data if data valid
                if (!$term->delete()) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    // Function for get term data
    public static function getTerms($taxonomy = false, $arg = false)
    {
        // Checking post_id data can't be empty
        if (!$taxonomy) {
            return collect([]);
        }

        //@TODO join taxonomy where taxonomy name
        $terms = Term::whereHas('taxonomy', function ($query) use ($taxonomy) {
            $query->where('taxonomy_name', '=', $taxonomy);
        });

        // Checking arg data
        if ($arg) {
            // Checking arg data if not in array type
            if (!is_array($arg)) {
                return false;
            }

            foreach ($arg as $key => $value) {
                $orderby = 'id';
                $order = 'ASC';
                $paginate = 10;
                switch ($key) {
                    case 'order_by':
                        $termModel = new Term;
                        // Checking field name
                        if (in_array($value, $termModel->getFillable())) {
                            $orderby = $value;
                        } else {
                            return false;
                        }
                        break;
                    case 'order':
                        $order = $value;
                        break;
                    case 'child':
                        if (!((boolean)$value)) {
                            $terms = $terms->where('parent', '=', 0);
                        }
                        break;
                    case 'paginate':
                        $paginate = (int)$value;
                        break;
                }
            }

            $terms =  $terms->orderBy($orderby, $order)->paginate($paginate);
        } else {
            $terms = $terms->orderBy('parent')->get();
        }

        return $terms;
    }

    // Function for add term data
    public static function addTerm($taxonomyName = false, $name= false, $slug = false, $parent = false)
    {
        // Checking taxonomy data can't be empty
        if (!$taxonomyName) {
            return false;
        } else {
            // Checking taxonomy
            $taxonomy = Taxonomy::where('taxonomy_name', $taxonomyName)->first();

            if (!$taxonomy) {
                return false;
            }
        }

        // Checking parent data if data null or empty
        if (!$parent) {
            $parent = 0;
        } else {
            // Get term parent with make sure parent data integer
            $cterm = Term::find((int)$parent);
            // Checking term parent valid or invalid
            if ($cterm) {
                // Checking term parent in same taxomony
                if ($cterm->taxonomy_id != $taxonomy->id) {
                    return false;
                }
            } else {
                return false;
            }
        }

        // Data input
        $save = [
            'taxonomy_id' => (int) $taxonomy->id,
            'name' => $name,
            'slug' => $slug,
            'parent' => (int)$parent
        ];

        $term = new Term;
        // Checking data input
        $validator = $term->validate($save);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return false;
        }
        $term->taxonomy_id = $save['taxonomy_id'];
        $term->name = $save['name'];
        $term->slug = $save['slug'];
        $term->parent = $save['parent'];
        // Create new data
        if ($term->save()) {
            return true;
        } else {
            return false;
        }
    }


    // Function for update term data
    public static function updateTerm($termID = false, $name= false, $slug = false, $parent = false)
    {
        $term = Term::find($termID);

        if (!$term) {
            return;
        }

        // Checking parent data if data null or empty
        if (!$parent) {
            $parent = 0;
        } else {
            // Get term parent with make sure parent data integer
            $cterm = Term::find((int)$parent);
            // Checking term parent valid or invalid
            if ($cterm) {
                // Checking term parent in same taxomony
                if ($cterm->taxonomy_id != $term->taxonomy_id) {
                    return false;
                }
            } else {
                return false;
            }
        }
        // Data input
        $save = [
            'taxonomy_id' => $term->taxonomy_id,
            'name' => $name,
            'slug' => $slug,
            'parent' => (int) $parent
        ];

        // Checking data input
        $validator = $term->validate($save);

        if ($validator->fails()) {
            foreach ($validator->messages()->toArray() as $v) {
                admin_notice('danger', $v[0]);
            }
            return false;
        }
        $term->taxonomy_id = $save['taxonomy_id'];
        $term->name = $save['name'];
        $term->slug = $save['slug'];
        $term->parent = $save['parent'];

        // Update new data
        if ($term->save()) {
            return true;
        } else {
            return false;
        }
    }
}
