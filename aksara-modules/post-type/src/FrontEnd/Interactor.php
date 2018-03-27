<?php

namespace Plugins\PostType\FrontEnd;

class Interactor implements FrontEndInterface
{
    /**
     * Registering front end route
     */
    function boot()
    {
        \Eventy::addAction('aksara.routes.front_end',function(){
            \Permalink::generatePostArchivePermalinkRoutes();
            \Permalink::generateSearchRoute();
            \Permalink::generatePostPermalinkRoutes();
            \Permalink::generateHomeRoute();
            \Permalink::generateCatchAll();
        },99);
    }
}
