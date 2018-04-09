<?php

use \App\Aksara\Core\Menu as Menu;

function get_active_backend()
{
    $activeBackends = \ModuleRegistry::getActiveModuleByType('backend');
    //get last backend
    $backend = $activeBackends[count($activeBackends) - 1];
    return $backend;
}

function get_active_backend_name()
{
    return get_active_backend()->getName();
}

function get_active_backend_view($view)
{
    $backend = get_active_backend_name();
    $customView = sprintf("%s::%s", $backend, $view);

    if (view()->exists($customView)) {
        return $customView;
    } else {
        $defaultBackendConfig = config('aksara.default_backend');
        $defaultView = sprintf("%s::%s", $defaultBackendConfig, $view);
        return $defaultView;
    }
    return false;
}

function render_admin_menu()
{
    $menu = new \App\Aksara\Core\AdminMenu\AdminMenu();
    $menu->render();
}

function admin_notice($labelClass, $content, bool $useConfig = false)
{
    $notices = [];
    $notice = [
        'labelClass' => $labelClass,
        'content' => $content
    ];

    if ($useConfig) {
        $messages = \Config::get('aksara.admin_notice', []);
        array_push($messages, $notice);
        \Config::set('aksara.admin_notice', $messages);
        return;
    }

    if (session()->has('admin_notice')) {
        $messages = session('admin_notice');
        array_push($messages, $notice);
        session()->put('admin_notice', $messages);
    } else {
        session()->put('admin_notice', [ $notice ]);
    }

}

function render_admin_notice()
{
    $notices = [];

    if (session()->has('admin_notice')) {
        $notices = session()->get('admin_notice');
    }
    $notices = array_merge($notices, \Config::get('aksara.admin_notice', []));

    foreach ($notices as $data) {
        echo view(get_active_backend_view('partials.notice'), $data)->render();
    }

    \Config::set('aksara.admin_notice', []);
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
