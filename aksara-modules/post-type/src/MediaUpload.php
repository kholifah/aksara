<?php
namespace Plugins\PostType;

use Plugins\PostType\Model\Post;
use Illuminate\Support\Facades\Validator;

class MediaUpload
{
    protected $request;

    function __construct($request)
    {
        $this->request = $request;
    }

    private function getSupportedMimesParam()
    {
        return implode(',',
            array_merge(
                config('mimes.image'),
                config('mimes.document'),
                config('mimes.video'),
                config('mimes.audio')
            )
        );
    }

    public function handle()
    {
        $validator = Validator::make($this->request->all(),
            [
                'file' => 'mimetypes:' . $this->getSupportedMimesParam(),
            ],
            [
                'file.mimetypes' => 'Uploaded file format is not supported.'
            ]);

        if ($validator->fails())
            return array(
                'fail' => true,
                'errors' => $validator->getMessageBag()->toArray()
            );

        // Upload file to proper location
        $extension = $this->request->file('file')->getClientOriginalExtension(); // getting image extension
        $extension = strtolower($extension);

        $yearMonth = \Carbon\Carbon::now();
        $path = 'uploads/'.$yearMonth->format('Y/m').'/';

        $filename = uniqid() . '_' . time() . '.' . $extension;
        $this->request->file('file')->move($path, $filename);

        $imagePath = $path.$filename;
        $imageAbsolutePath = url($imagePath);

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
        set_post_meta($post->id,'post_image',$imagePath);

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
