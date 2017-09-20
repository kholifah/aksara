<?php
namespace App\Modules\Plugins\PostType;

class MetaBox
{

  function __construct()
  {
    $postTypes = \Config::get('aksara.post_type',[]);

    foreach ($postTypes as $postType => $args )
    {
      \Eventy::addAction('aksara.post_editor.'.$postType.'.after_editor','App\Modules\Plugins\PostType\Metabox@renderDefault');
      \Eventy::addAction('aksara.post_editor.'.$postType.'.sidebar','App\Modules\Plugins\PostType\Metabox@renderSidebar');
      \Eventy::addAction('aksara.'.$postType.'.create','App\Modules\Plugins\PostType\Metabox@saveMetabox',10,2);
      \Eventy::addAction('aksara.'.$postType.'.update','App\Modules\Plugins\PostType\Metabox@saveMetabox',10,2);
    }
  }

  // location default / sidebar
  function add(string $id, string $postType,string $callbackRender,string $callbackSave ="",string $location = "default",  $priority = 10 )
  {
    $metaboxes = \Config::get('aksara.metaboxes',[]);

    if( !isset($metaboxes[$postType]) )
      $metaboxes[$postType] = [];

    if( !isset($metaboxes[$postType][$location]) )
      $metaboxes[$postType][$location] =[];

    if( !isset($metaboxes[$postType][$location][$priority]) )
      $metaboxes[$postType][$location][$priority] =[];

    $args = [
      'callbackRender' => $callbackRender,
      'callbackSave' => $callbackSave,
      'id' => $id,
    ];

    array_push( $metaboxes[$postType][$location][$priority], $args);

    \Config::set('aksara.metaboxes',$metaboxes);

  }

  function renderSidebar($parameters=[])
  {
    $this->render('sidebar',$parameters);
  }

  function renderDefault($parameters=[])
  {
    $this->render('default',$parameters);
  }

  function saveMetabox($post,$request)
  {
    $postType = get_current_post_type();

    $metaboxes = \Config::get('aksara.metaboxes',[]);

    if( !isset($metaboxes[$postType]) )
      return;

    foreach ( $metaboxes[$postType] as $location => $priority) {
      foreach (  $priority as $metabox => $metaboxArgs ) {
        foreach ($metaboxArgs as $metaboxArg) {
          $callback = get_calback($metaboxArg['callbackSave']);
          call_user_func_array( $callback, [$post,$request]);
        }
      }
    }

  }

  function render( $location, $post )
  {
    $postType = get_current_post_type();

    $metaboxes = \Config::get('aksara.metaboxes',[]);

    if( !isset($metaboxes[$postType]) )
      return;

    if( !isset($metaboxes[$postType][$location]) )
      return;

    // sort by priority
    ksort($metaboxes[$postType][$location]);

    // start render
    foreach ($metaboxes[$postType][$location] as $priority => $metabox) {
      foreach ($metabox as $metaboxArg ) {

        $callback = get_calback($metaboxArg['callbackRender']);

        echo '<div id="'.$metaboxArg['id'].'" class="metabox">';
        call_user_func_array( $callback, [$post]);
        echo '</div>';

      }
    }

  }

}
