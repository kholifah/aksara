<?php
namespace App\Modules\Plugins\PostType;

class MetaBox
{
    public function init()
    {
        \Eventy::addAction('aksara.init_completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types', []);

            foreach ($postTypes as $postType => $args) {
                \Eventy::addAction('aksara.post_editor.'.$postType.'.metabox', 'App\Modules\Plugins\PostType\MetaBox@renderMetabox');
                \Eventy::addAction('aksara.post_editor.'.$postType.'.metabox-sidebar', 'App\Modules\Plugins\PostType\MetaBox@renderMetaboxSidebar');
                \Eventy::addAction('aksara.post-type.'.$postType.'.create', 'App\Modules\Plugins\PostType\MetaBox@saveMetabox', 10, 2);
                \Eventy::addAction('aksara.post-type.'.$postType.'.update', 'App\Modules\Plugins\PostType\MetaBox@saveMetabox', 10, 2);
            }
        });
    }

    // location default / sidebar
    public function add(string $id, string $postType, string $callbackRender = null, string $callbackSave = null, string $location = "metabox", $priority = 10)
    {
        $metaboxes = \Config::get('aksara.metaboxes', []);

        if (!isset($metaboxes[$postType])) {
            $metaboxes[$postType] = [];
        }

        if (!isset($metaboxes[$postType][$location])) {
            $metaboxes[$postType][$location] =[];
        }

        if (!isset($metaboxes[$postType][$location][$priority])) {
            $metaboxes[$postType][$location][$priority] =[];
        }

        $args = [
         'callbackRender' => $callbackRender,
         'callbackSave' => $callbackSave,
         'id' => $id,
      ];

        array_push($metaboxes[$postType][$location][$priority], $args);

        \Config::set('aksara.metaboxes', $metaboxes);
    }

    public function renderMetaboxSidebar($parameters=[])
    {
        $this->render('metabox-sidebar', $parameters);
    }

    public function renderMetabox($parameters=[])
    {
        $this->render('metabox', $parameters);
    }

    public function saveMetabox($post, $request)
    {
        $postType = get_current_post_type();

        $metaboxes = \Config::get('aksara.metaboxes', []);

        if (!isset($metaboxes[$postType])) {
            return;
        }


        foreach ($metaboxes[$postType] as $location => $priority) {
            foreach ($priority as $metabox => $metaboxArgs) {
                foreach ($metaboxArgs as $metaboxArg) {
                    if (!$metaboxArg['callbackSave']) {
                        continue;
                    }

                    $callback = get_calback($metaboxArg['callbackSave']);
                    call_user_func_array($callback, [$post,$request]);
                }
            }
        }
    }

    public function render($location, $post)
    {
        $postType = get_current_post_type();

        $metaboxes = \Config::get('aksara.metaboxes', []);

        if (!isset($metaboxes[$postType])) {
            return;
        }

        if (!isset($metaboxes[$postType][$location])) {
            return;
        }

        // sort by priority
        ksort($metaboxes[$postType][$location]);


        // start render
        foreach ($metaboxes[$postType][$location] as $priority => $metabox) {
            foreach ($metabox as $metaboxArg) {
                if (!$metaboxArg['callbackRender']) {
                    continue;
                }

                $callback = get_calback($metaboxArg['callbackRender']);

                echo '<div id="'.$metaboxArg['id'].'" class="metabox">';
                call_user_func_array($callback, [$post]);
                echo '</div>';
            }
        }
    }
}
