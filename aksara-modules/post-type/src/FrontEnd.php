<?php
namespace Plugins\PostType;

use Plugins\PostType\Repository\AksaraQuery;

class FrontEnd
{
    /**
     * Registering front end route
     */
    function init()
    {
        \Eventy::addAction('aksara.routes.front_end',function(){
            $permalink = \App::make('Plugins\PostType\Permalink');

            $permalink->generatePostArchivePermalinkRoutes();
            $permalink->generateSearchRoute();
            $permalink->generatePostPermalinkRoutes();
            $permalink->generateHomeRoute();
            $permalink->generateCatchAll();


        },99);
    }
}
