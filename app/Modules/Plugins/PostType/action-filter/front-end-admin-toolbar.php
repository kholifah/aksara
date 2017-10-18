<?php
\Eventy::addAction('aksara.front-end.head',function(){
    if( !is_admin() && \Auth::check()) {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);

        aksara_enqueue_style(url("assets/modules/Plugins/PostType/css/admin-toolbar.min.css"));
        echo view('plugin:post-type::partials.header-admin-toolbar',compact('adminMenus'))->render();
    }
});
