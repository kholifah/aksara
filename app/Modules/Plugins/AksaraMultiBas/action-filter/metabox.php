<?php
// modify post ordering
\Eventy::addAction('aksara.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');

    foreach ($postTypes as $postType => $args) {
        add_meta_box('multibas', $postType, 'render_metabox_multibas', false, 'metabox-sidebar', 5);
    }
});

