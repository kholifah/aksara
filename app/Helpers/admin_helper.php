<?php

use \App\Aksara\Core\Menu as Menu;


function render_admin_menu()
{
  $menu = new \App\Aksara\Core\AdminMenu\AdminMenu();
  $menu->render();
}

function get_current_post_type()
{
  $post = \App::make('post');
  return $post->getCurrentPostType();
}

// function get_current_post_type_args('route')
// {
//   $post = \App::make('post');
//   return $post->getCurrentPostType();
// }

function get_post_type_args($key = false)
{
  $post = \App::make('post');
  return $post->getPostTypeArgs($key);
}

function get_current_post_type_args($key = false)
{
    $args = get_post_type_args(get_current_post_type());

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

function get_taxonomy_args($key = false)
{
  $post = \App::make('post');
  return $post->getTaxonomyArgs($key);
}

function get_current_taxonomy_args( $key = false )
{
    $args = get_taxonomy_args(get_current_taxonomy());
    return array_get($args,$key);
}

function admin_notice( $labelClass, $content )
{
  $adminNotices = Session::get('message');

  if( !is_array( $adminNotices ) )
    $adminNotices = [];

  array_push($adminNotices,[
    'labelClass' => $labelClass,
    'content' => $content
  ]);

  Session::put('message', $adminNotices);

}

function render_admin_notice()
{
  $value = Session::get('message');
  if( !is_array($value) )
    return;

  foreach ($value as $data)
  {
    $parameters = [];
    $parameters['labelClass'] = $data['labelClass'];
    $parameters['content'] = $data['content'];

    echo view('admin:aksara::partials.notice', $parameters )->render();
  }
  Session::forget('message');
}



function render_paging($data = FALSE, $filters = FALSE)
{
    if($data)
    {
        if($filters)
        {
            return with(new App\Aksara\Core\Pagination($data->appends($filters)))->render();
        } else {
            return with(new App\Aksara\Core\Pagination($data))->render();
        }
    }
    return ;
}
