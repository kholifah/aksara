<?php

namespace App\Models;

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
            'post_name' => 'required',
        ];

        $customMessages = [
            'post_name.required' => 'Bidang isian judul wajib diisi.'
        ];

        return \Validator::make($data, $rules, $customMessages);
    }

    public function scopeSetPostType($query, $post_type = false)
    {
      if( !$post_type )
      {
        $post_type = get_current_post_type();
      }

      if( !$post_type )
        $query;

       return $query->where('post_type', $post_type);
    }

    public function meta()
    {
        return $this->hasMany('App\Models\PostMeta', 'post_id');
    }

    public function term_relations()
    {
        return $this->hasMany('App\Models\TermRelationship', 'post_id');
    }


}
