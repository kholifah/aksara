<?php
namespace Plugins\PostType\MetaboxRegistry;

class Interactor implements MetaboxRegistryInterface
{
    public function boot()
    {
        \Eventy::addAction('aksara.init-completed', function () {
            $postTypes = \Config::get('aksara.post-type.post-types', []);

            foreach ($postTypes as $postType => $args) {
                \Eventy::addAction('aksara.post_editor.'.$postType.'.metabox', function ($parameters) {
                    $this->renderMetabox($parameters);
                });
                \Eventy::addAction('aksara.post_editor.'.$postType.'.metabox-sidebar', function ($parameters) {
                    $this->renderMetaboxSidebar($parameters);
                });
                \Eventy::addAction('aksara.post-type.'.$postType.'.create', function ($post, $request) {
                    $this->saveMetabox($post, $request);
                }, 10, 2);
                \Eventy::addAction('aksara.post-type.'.$postType.'.update', function ($post, $request) {
                    $this->saveMetabox($post, $request);
                }, 10, 2);
            }
        });
    }

    // location default / sidebar
    public function add(string $id, string $postType, $callbackRender = null, $callbackSave = null, string $location = "metabox", $priority = 10)
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

    public function addClass(MetaboxBase $metabox)
    {
        $this->add(
            $metabox->getId(),
            $metabox->getPostType(),
            $metabox->getCallbackRender(),
            $metabox->getCallbackSave(),
            $metabox->getLocation(),
            $metabox->getPriority()
        );
    }

    private function renderMetaboxSidebar($parameters=[])
    {
        $this->render('metabox-sidebar', $parameters);
    }

    private function renderMetabox($parameters=[])
    {
        $this->render('metabox', $parameters);
    }

    private function saveMetabox($post, $request)
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

                    $callback = get_callback($metaboxArg['callbackSave']);
                    call_user_func_array($callback, [$post,$request]);
                }
            }
        }
    }

    private function render($location, $post)
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

                $callback = get_callback($metaboxArg['callbackRender']);

                echo '<div id="'.$metaboxArg['id'].'" class="metabox">';
                call_user_func_array($callback, [$post]);
                echo '</div>';
            }
        }
    }
}
