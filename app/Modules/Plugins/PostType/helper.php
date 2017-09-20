<?php
use App\Models\PostMeta;
use App\Models\TermRelationship;
use App\Models\Term;
use App\Models\Taxonomy;

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
    if ($status)
    {
        return $stat[$status];
    } else {
        return $stat;
    }
}

function register_post_type( $postType, $args )
{
    $post = \App::make('post');
    $post->registerPostType( $postType, $args);
}

function add_meta_box( string $id, string $postType,string $callbackRender,string $callbackSave="",string $location = "default",  $priority = 10 )
{
    $metabox = \App::make('App\Modules\Plugins\PostType\MetaBox');
    $metabox->add( $id, $postType, $callbackRender, $callbackSave,$location, $priority );
}

// Function for delete term data
function delete_post_term($postID = false, $taxonomy = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::delete_post_term($postID, $taxonomy);
    return $postterm;
}

// Function for get post term data
function get_post_term($postID = false, $taxonomy = false, $arg = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::get_post_term($postID, $taxonomy, $arg);
    return $postterm;
}

// Function for set post term data
function set_post_term($postID = false, $taxonomy = false, $term = false)
{
    // To function delete_options in TermRelationship model
    $postterm = TermRelationship::set_post_term($postID, $taxonomy, $term);
    return $postterm;
}

// Function for delete term data
function delete_term($termID = false)
{
    // To function delete_options in Term model
    $term = Term::delete_term($termID);
    return $term;
}

// Function for get term data
function get_term($taxonomy = false, $arg = false)
{

    $term = Term::get_term($taxonomy, $arg);
    return $term;
}

// Function for add term data
function add_term($taxonomy = false, $name= false, $slug = false, $parent = false)
{
    // To function delete_options in Term model
    $term = Term::add_term($taxonomy, $name, $slug, $parent);
    return $term;
}


// Function for update term data
function update_term($termID = false, $name= false, $slug = false, $parent = false)
{
    // To function delete_options in Term model
    $term = Term::update_term($termID, $name, $slug, $parent);
    return $term;
}


// Function for get term data
function get_taxonomy()
{
    // To function get_taxonomy in Taxonomy model
    $taxonomy = Taxonomy::get_taxonomy();
    return $taxonomy;
}

function register_taxonomy($taxonomy, $postType, $args )
{
    $post = \App::make('post');
    $post->registerTaxonomy( $taxonomy, $postType, $args);
}

function check_taxonomy($postType = false, $taxonomy= false)
{
    $taxonomy = Taxonomy::check_taxonomy($postType, $taxonomy);
    return $taxonomy;
}
