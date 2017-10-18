<?php
\Eventy::addAction('aksara.front-end.head',function(){
    if( !is_admin() && \Auth::check()) {
        aksara_enqueue_style(url("assets/modules/Plugins/PostType/css/admin-toolbar.min.css"));
    }
});
\Eventy::addAction('aksara.front-end.footer',function(){
    if( !is_admin() && \Auth::check()) {
        $adminMenus = \Config::get('aksara.admin-menu.toolbar-dropdown-menu',[]);

        $posts = get_current_aksara_query();
        $post = count($posts) != 0 ?  $posts[0] : false ;

        echo view('plugin:post-type::partials.header-admin-toolbar',compact('adminMenus','post'))->render();
    }
});
