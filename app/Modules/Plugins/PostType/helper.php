<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\TermRelationship;
use App\Modules\Plugins\PostType\Model\Term;
use App\Modules\Plugins\PostType\Model\Taxonomy;


function get_post_title($post)
{
    return \Eventy::filter('aksara.post-type.front-end.post-title',$post->post_title,$post);
}

function get_post_content($post)
{
    return \Eventy::filter('aksara.post-type.front-end.post-content',$post->post_content,$post);
}

function get_post_excerpt($post)
{
    return \Eventy::filter('aksara.post-type.front-end.post-excerpt',$post->post_content,$post);
}

function get_post_permalink($post)
{
    $postClass = \App::make('App\Modules\Plugins\PostType\Post');
    return $postClass->getPermalink($post);
}

function get_post_permalink_structure($post)
{
    $postClass = \App::make('App\Modules\Plugins\PostType\Post');
    return $postClass->getPermalinkStructure($post);
}

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

function get_post_featured_image($post,$size=false)
{
    $postId = $post->id;
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


function get_current_post_type()
{
  $post = \App::make('post');
  return $post->getCurrentPostType();
}

function get_current_post_type_from_route($delimiter = false)
{
  $post = \App::make('post');
  return $post->getPostTypeFromRoute($delimiter);
}

function get_current_taxonomy_from_route($delimiter = false)
{
  $post = \App::make('post');
  return $post->getTaxonomyFromRoute($delimiter);
}

function get_post_type_args($key,$postType = false)
{
  $post = \App::make('post');

  $args = $post->getPostTypeArgs($postType);

  return array_get($args,$key);
}

function get_current_post_type_args($key = false)
{
    $postType = get_current_post_type();

     $post = \App::make('post');

    $args = $post->getPostTypeArgs($postType);

    return array_get($args,$key);
}


function get_current_taxonomy()
{
  $post = \App::make('post');
  return $post->getCurrentTaxonomy();
}

// function get_current_taxonomy_args('slug')
// {
//   $post = \App::make('post');
//   return $post->getCurrentTaxonomy();
// }

function get_taxonomy_args($key,$taxonomy = false)
{
  $post = \App::make('post');
  $args = $post->getTaxonomyArgs($taxonomy);

  return array_get($args,$key);
}

function get_current_taxonomy_args( $key = false )
{
    return get_taxonomy_args($key,get_current_taxonomy());
    // return array_get($args,$key);
}

function is_home() {
    return \Config::get('aksara.post-type.front-end.template.is_home',false);
}

function is_single() {
    return \Config::get('aksara.post-type.front-end.template.is-single',false);
}

function is_archive() {
    return \Config::get('aksara.post-type.front-end.template.is-archive',false);
}

function is_archive_post_type() {
    return \Config::get('aksara.post-type.front-end.template.is-archive-post-type',false);
}

function is_archive_taxonomy() {
    return \Config::get('aksara.post-type.front-end.template.is-archive-taxonomy',false);
}

function is_search() {
    return \Config::get('aksara.post-type.front-end.template.is-search',false);
}

//@TODO Translasi
function get_archive_title() {
    if( is_archive_taxonomy() ) {
        echo get_taxonomy_args('label.name',get_current_taxonomy()).' Archive ';
    }
    elseif( is_archive_post_type() ) {
        // @ Todo Translasi
        echo get_post_type_args('label.name',get_current_post_type()).' Archive ';
    }
    elseif( is_search() ) {
        echo 'Search Archive';
    }
    elseif( is_archive() ) {
        echo 'Archive';
    }
}

function get_search_results() {
    if( is_search() ) {
        $aksaraQuery = get_current_aksara_query();
        echo 'Search Query : "'.\Request::input('query').'", found '.$aksaraQuery->total().' result(s).';
    }
}

function set_current_post($post)
{
    app()['currentAksaraPost'] = $post;
}


function get_current_post()
{
    try {
        $aksaraQuery = app()['currentAksaraPost'];
        return $aksaraQuery;
    }
    catch(\Exception $e) {
        return false;
    }
}


function get_current_aksara_query()
{
    try {
        $aksaraQuery = app()['currentAksaraQuery'];
        return $aksaraQuery->paginate();
    }
    catch(\Exception $e) {
        return false;
    }
}

function set_current_aksara_query($aksaraQuery) {
    app()['currentAksaraQuery'] = $aksaraQuery;
}
