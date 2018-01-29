<?php

use \App\Aksara\Core\Menu as Menu;


function render_admin_menu()
{
    $menu = new \App\Aksara\Core\AdminMenu\AdminMenu();
    $menu->render();
}

function admin_notice( $labelClass, $content )
{
    $adminNotices = session()->get('admin_notice');

    if(!is_array($adminNotices)) {
        $adminNotices = [];
    }

    array_push($adminNotices,[
        'labelClass' => $labelClass,
        'content' => $content
    ]);

    session()->flash('admin_notice', $adminNotices);
}

function render_admin_notice()
{
    $adminNotices = session()->get('admin_notice');

    if(!is_array($adminNotices)) {
        return;
    }

    foreach ($adminNotices as $data) {
        echo view('admin:aksara::partials.notice', $data)->render();
    }
}



function render_paging($data = FALSE, $filters = FALSE)
{
    if($data)
    {
        if($filters) {
            return with(new App\Aksara\Core\Pagination($data->appends($filters)))->render();
        } else {
            return with(new App\Aksara\Core\Pagination($data))->render();
        }
    }
    return ;
}
