<?php
namespace App\Modules\Plugins\PostType\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['post_type', 'post_author', 'post_date', 'post_modified', 'post_status', 'post_name', 'post_title', 'post_slug', 'post_content', 'post_image'];
    public $timestamps = false;

    public function validate($data)
    {
        $rules = [
            'post_type' => 'required|max:20',
            'post_status' => 'required|max:20',
        ];

        $customMessages = [
            'post_name.required' => 'Bidang isian judul wajib diisi.'
        ];

        return \Validator::make($data, $rules, $customMessages);
    }

    public function scopeSetPostType($query, $post_type = false)
    {
        if (!$post_type) {
            $post_type = get_current_post_type();
        }

        if (!$post_type) {
            $query;
        }

        return $query->where('post_type', $post_type);
    }

    public function meta()
    {
        return $this->hasMany('App\Modules\Plugins\PostType\Model\PostMeta', 'post_id');
    }

    //@TODO rename to termRelations
    public function term_relations()
    {
        return $this->hasMany('App\Modules\Plugins\PostType\Model\TermRelationship', 'post_id');
    }

    //@TODO rename to termRelations
    public function author()
    {
        return $this->hasOne('App\User', 'id','post_author');
    }
}
