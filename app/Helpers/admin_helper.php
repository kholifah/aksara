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
    $notice = [
        'labelClass' => $labelClass,
        'content' => $content
    ];

    if (session()->has('admin_notice')) {
        $messages = session('admin_notice');
        array_push($messages, $notice);
        session()->flash('admin_notice', $messages);
    } else {
        session()->flash('admin_notice', [ $notice ]);
    }
}

function render_admin_notice()
{
    $notices = [];

    if (session()->has('admin_notice')) {
        $notices = session()->get('admin_notice');
    }

    foreach ($notices as $data) {
        echo view('aksara-backend::partials.notice', $data)->render();
    }

    session()->forget('admin_notice');
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
