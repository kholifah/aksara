<?php

use \App\Aksara\Core\Menu as Menu;


function render_admin_menu()
{
  $menu = new \App\Aksara\Core\AdminMenu\AdminMenu();
  $menu->render();
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
