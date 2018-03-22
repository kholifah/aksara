<?php
namespace Plugins\AksaraMultiBas;
use App\Modules\Plugins\PostType\Model\PostMeta as PostMeta;
use App\Modules\Plugins\PostType\Model\Post as Post;
use App\Modules\Plugins\PostType\Model\TermRelationship as TermRelationship;

class TranslationEngine
{
    function getTranslatedPost($post, $lang)
    {
        if(get_post_meta($post->id,'is_translation'))
            return false;

        $translatedPost = PostMeta::where('meta_key','multibas-translation-'.$lang)
                            ->where('meta_value',$post->id)
                            ->first();

        if( !$translatedPost ) {
            return false;
        }

        return Post::where('id',$translatedPost->post_id)->first();
    }

    /*
     * Create post translation
     */
    function createPostTranslation($postId,$lang)
    {
        // Check if post is translation
        if(get_post_meta($postId,'is_translation')) {
            return false;
        }

        $post = Post::find($postId);

        $translatedPost = new Post;
        $translatedPost->post_type = $post->post_type;
        $translatedPost->post_author = $post->post_author;
        $translatedPost->post_content = "";
        $translatedPost->post_title = "";
        $translatedPost->post_slug = "";
        $translatedPost->post_image = "";
        $translatedPost->post_date = date('Y-m-d H:i:s');
        $translatedPost->post_modified = date('Y-m-d H:i:s');
        $translatedPost->post_status = $post->post_status;
        $translatedPost->save();

        $postMetas = PostMeta::where('post_id',$postId)->get();

        foreach ($postMetas as $postMeta) {
            set_post_meta($translatedPost->id,$postMeta['meta_key'],$postMeta['meta_value']);
        }

        set_post_meta($translatedPost->id,'is_translation',true);
        set_post_meta($translatedPost->id,'multibas-translation-'.$lang,$postId);

        // Copy Taxonomy
        $TermRelationships = TermRelationship::where('post_id',$postId)->get();

        foreach ($TermRelationships as $termRelationship) {
            $newTermRelationship = new TermRelationship();
            $newTermRelationship->post_id = $translatedPost->id;
            $newTermRelationship->term_id = $termRelationship->term_id;
            $newTermRelationship->save();
        }

        return $translatedPost;
    }
}
