<?php
namespace App\Modules\Plugins\PostType\Model;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $table = 'post_meta';
    protected $fillable = ['meta_key', 'meta_value', 'post_id'];
    public $timestamps = false;

    public function validate($data)
    {
        $rules = [
            'meta_key' => 'required|max:40',
            'post_id' => 'required',
        ];

        return \Validator::make($data, $rules);
    }

    public function post()
    {
        return $this->belongsTo('App\Modules\Plugins\PostType\Model\Post', 'post_id');
    }

    // Function for delete post meta data
    public static function delete_post_meta($postID = false, $key = false)
    {
        //Checking post_id data can't be empty
        if (!$postID) {
            return false;
        } else {
            //Checking Post data
            $post = Post::find($postID);
            if (!$post) {
                return false;
            }
        }

        //Checking key data
        if ($key) {
            // Get post meta data from db
            $post_meta = PostMeta::where('post_id', $postID)->where('meta_key', $key)->first();
            // Checking post meta data
            if ($post_meta) {
                // Delete post meta data if data valid
                $post_meta->delete();
            } else {
                return false;
            }
        } else {
            // Get post meta data from db
            $post_meta = PostMeta::where('post_id', $postID);
            // Checking post meta data
            if ($post_meta->count()) {
                // Delete post meta data if data valid
                $post_meta->delete();
            } else {
                return false;
            }
        }


        return true;
    }

    // Function for get post meta data
    public static function get_post_meta($postID = false, $key = false, $default = false)
    {
        // Checking post_id data can't be empty
        if (!$postID) {
            if ($default === false) {
                return false;
            } else {
                return $default;
            }
        } else {
            // Checking post data
            $post = Post::find($postID);
            if (!$post) {
                if ($default === false) {
                    return false;
                } else {
                    return $default;
                }
            }
        }

        // Checking key data can't be empty
        if (!$key) {
            return false;
        }

        // Get post meta data from db
        $post_meta = PostMeta::where('post_id', $postID)->where('meta_key', $key)->first();

        // Checking post meta data
        if ($post_meta) {
            // Checking value data to unserialize or change string to array data
            $dataUnserialize = @unserialize($post_meta->meta_value);

            if ($dataUnserialize !== false) {
                return $dataUnserialize;
            } else {
                return $post_meta->meta_value;
            }
        } elseif ($default !== false) {
            return $default;
        }

        return false;
    }

    // Function for setting post meta data
    public static function set_post_meta($postID = false, $key = false, $value = false, $serialize = false)
    {
        // Checking post_id data can't be empty
        if (!$postID) {
            return false;
        } else {
            // Checking post data
            $post = Post::find($postID);
            if (!$post) {
                return false;
            }
        }

        // Checking key data can't ne empty
        if (!$key) {
            return false;
        }

        // Get post meta data from db
        $post_meta = PostMeta::where('post_id', $postID)->where('meta_key', $key)->first();
        $data = '';

        // Checking value data to unserialize or change array data to string data
        if( is_object($value) || is_array($value) ) {

            $dataSerialize = @serialize($value);

            if ($dataSerialize !== false) {
                $data = $dataSerialize;
            } else {
                $data = $value;
            }
        }
        else {
            $data = $value;
        }



        $save = [
            'meta_key' => $key,
            'meta_value' => $data,
            'post_id' => $postID
        ];

        // Checking post meta data
        if ($post_meta) {
            // Checking data input
            $validator = $post_meta->validate($save);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Checking value data
            if ($data) {
                $post_meta->meta_key = $save['meta_key'];
                $post_meta->meta_value = $save['meta_value'];
                $post_meta->post_id = $save['post_id'];
                // Update post meta data
                if ($post_meta->save()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                // Delete post meta data if value data empty
                if ($post_meta->delete()) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            // If post meta data not in db, create new data
            $post_meta = new PostMeta;
            // Checking data input
            $validator = $post_meta->validate($save);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $post_meta->meta_key = $save['meta_key'];
            $post_meta->meta_value = $save['meta_value'];
            $post_meta->post_id = $save['post_id'];
            if ($post_meta->save()) {
                return true;
            } else {
                return false;
            }
        }
    }
}
