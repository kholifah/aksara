<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\TermRelationship;
use App\Modules\Plugins\PostType\Model\Term;
use App\Modules\Plugins\PostType\Model\Taxonomy;

/**
 * [registerImageSize description]
 * @param  string  $name   Image size id
 * @param  integer $width  Image width
 * @param  integer $height Image height
 * @param  boolean $crop   Crop center on Image
 * @param  boolean $aspectRatio   Preserve aspect ratio
 * @return boolean
 */
function register_image_size($name, $width = 0, $height = 0, $crop = true, $aspectRatio = true)
{
    $media = \App::make('App\Modules\Plugins\PostType\Media');

    return $media->registerImageSize($name, $width, $height, $crop, $aspectRatio );
}

function get_image_size($id,$imageURL)
{
    $imageSizes = \Config::get('aksara.post-type.image-sizes',[]);
    if( !isset($imageSizes[$id]) )
        return $imageURL;

    $pos = strrpos($imageURL, '.');
    return substr($imageURL, 0, $pos)  ."-{$imageSizes[$id]['width']}x{$imageSizes[$id]['height']}". substr($imageURL, $pos);
}

function add_page_template($name, $path)
{
    $pageTemplates = \Config::get('aksara.post-type.page-templates', []);

    $pageTemplates[$name] = $path;

    \Config::set('aksara.post-type.page-templates', $pageTemplates);
}

function get_featured_image($postId,$size=false)
{
    $postTumbnailId = get_post_meta($postId,'featured_image_post_id',false);

    if(!$postTumbnailId) {
        return false;
    }

    return get_post_image($postTumbnailId,$size);
}

function get_featured_image_id($postId,$size=false)
{
    return get_post_meta($postId,'featured_image_post_id',false);
}

function get_post_image($postId,$size = false)
{
    if(get_post_meta($postId,'post_image',false)) {
        $imageUrl = url(get_post_meta($postId,'post_image',false)) ;
        if( !$size) {
            return $imageUrl;
        }
        else {
            return get_image_size($size, $imageUrl);
        }
    }
    else {
        return "";
    }
}

function get_page_template($post)
{
    return get_post_meta($post->id, 'page_template', false);
}

function aksara_media_uploader()
{
    $media = \App::make('App\Modules\Plugins\PostType\Media');

    $media->enqueueScript();
}

// Function for delete post meta data
function delete_post_meta($postID = false, $key = false)
{
    // To function delete_options in PostMeta model
    $post_meta = PostMeta::delete_post_meta($postID, $key);
    return $post_meta;
}

// Function for get post meta data
function get_post_meta($postID = false, $key = false, $default = false)
{
    // To function delete_options in PostMeta model
    $post_meta = PostMeta::get_post_meta($postID, $key, $default);
    return $post_meta;
}

// Function for setting post meta data
function set_post_meta($postID = false, $key = false, $value = false)
{
    // To function delete_options in PostMeta model
    $post_meta = PostMeta::set_post_meta($postID, $key, $value);
    return $post_meta;
}

function status_post($status = false)
{
    $stat = [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'publish' => 'Published',
        'trash' => 'Trash'
    ];
    //Checking status
    if ($status) {
        return $stat[$status];
    } else {
        return $stat;
    }
}

function register_post_type($postType, $args)
{
    $post = \App::make('post');
    $post->registerPostType($postType, $args);
}

function add_meta_box(string $id, string $postType, string $callbackRender, string $callbackSave = null, string $location = "metabox", $priority = 20)
{
    $metabox = \App::make('App\Modules\Plugins\PostType\MetaBox');
    $metabox->add($id, $postType, $callbackRender, $callbackSave, $location, $priority);
}

// Function for delete term data
function delete_post_term($postID = false, $taxonomy = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::delete_post_term($postID, $taxonomy);
    return $postterm;
}

// Function for get post term data
//
// $term (string|array)=> term id or term slug
function get_post_terms($postID = false, $taxonomy = false, $arg = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::getPostTerms($postID, $taxonomy, $arg);
    return $postterm;
}

// Function for set post term data
function set_post_terms($postID = false, $taxonomy = false, $term = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::set_post_term($postID, $taxonomy, $term);
    return $postterm;
}

// Function for delete term data
function delete_term($termID = false)
{
    // To function delete_options in Term model
    $term = Term::deleteTerm($termID);
    return $term;
}

// Function for get term data
function get_terms($taxonomy = false, $args = false)
{
    $term = Term::getTerms($taxonomy, $args);
    return $term;
}

// $args (String|Integer)
function get_term($taxonomy, $arg)
{
    return Term::getTerm($taxonomy, $arg);
}

// Function for add term data
function add_term($taxonomy = false, $name= false, $slug = false, $parent = false)
{
    // To function delete_options in Term model
    $term = Term::addTerm($taxonomy, $name, $slug, $parent);
    return $term;
}


// Function for update term data
function update_term($termID = false, $name= false, $slug = false, $parent = false)
{
    // To function delete_options in Term model
    $term = Term::updateTerm($termID, $name, $slug, $parent);
    return $term;
}


// Function for get term data
function get_taxonomies($postType = false)
{
    // To function get_taxonomies in Taxonomy model
    $taxonomy = Taxonomy::getTaxonomies($postType);
    return $taxonomy;
}

function register_taxonomy($taxonomy, $postType, $args)
{
    $post = \App::make('post');
    $post->registerTaxonomy($taxonomy, $postType, $args);
}

function add_post_type_to_taxonomy($taxonomy, $postType)
{
    $post = \App::make('post');
    $post->addPostTypeToTaxonomy($taxonomy, $postType);
}
