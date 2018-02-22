<?php

use \App\Aksara\Core\Menu as Menu;


function render_admin_menu()
{
    $menu = new \App\Aksara\Core\AdminMenu\AdminMenu();
    $menu->render();
}

function admin_notice($labelClass, $content)
{
    $notices = [];
    $message = [
        'labelClass' => $labelClass,
        'content' => $content
    ];

    if (session()->has('admin_notice')) {
        session()->push('admin_notice', $message);
    } else {
        session()->flash('admin_notice', [ $message ]);
    }
}

function render_admin_notice()
{
    $notices = [];

    if (session()->has('admin_notice')) {
        $notices = session()->get('admin_notice');
    }

    foreach ($notices as $data) {
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
