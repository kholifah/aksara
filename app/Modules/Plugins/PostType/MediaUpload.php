<?php
namespace App\Modules\Plugins\PostType;
use App\Modules\Plugins\PostType\Model\Post;
use Illuminate\Support\Facades\Validator;

class MediaUpload
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    function handle()
    {
        $validator = Validator::make($this->request->all(),
            [
                'file' => 'image',
            ],
            [
                'file.image' => 'The file must be an image (jpeg, png, bmp, gif, or svg)'
            ]);

        if ($validator->fails())
            return array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            );

        // Upload file to proper location
        $extension = $this->request->file('file')->getClientOriginalExtension(); // getting image extension

        $yearMonth = \Carbon\Carbon::now();
        $path = 'uploads/'.$yearMonth->format('Y/m').'/';

        $filename = uniqid() . '_' . time() . '.' . $extension;
        $this->request->file('file')->move($path, $filename);

        $imagePath = $path.'/'.$filename;
        $imageAbsolutePath = url($path).'/'.$filename;

        // Assign to media Post Type
        $post = new Post();
        $post->post_type = 'media';
        $post->post_status = 'publish';
        $post->post_author = \Auth::user()->id;
        $post->post_date = date('Y-m-d H:i:s');
        $post->post_modified = date('Y-m-d H:i:s');
        $post->post_content = '';
        $post->post_image = '';
        $post->post_title = $this->request->file('file')->getClientOriginalName();

        $post->save();

        // Set post meta
        set_post_meta($post->id,'image',$imagePath);

        return [
            'image_path'=>$imageAbsolutePath,
            'post_id'=>$post->id
        ];
    }

    function getDirectory()
    {

    }


    function createDirectory()
    {

    }
}
