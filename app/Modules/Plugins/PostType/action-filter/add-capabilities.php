<?php

// modify post ordering
\Eventy::addAction('aksara.init_completed', function () {
    $postTypes = \Config::get('aksara.post_type');

    foreach ($postTypes as $postType => $args) {
        $name = array_get($args, 'label.name');
        $slug = aksara_slugify($name);

        add_capability($name, $slug);
        add_capability("Add ".$name, "add-".$slug, $slug);
        add_capability("Edit ".$name, "edit-".$slug, $slug);
        add_capability("Delete ".$name, "delete-".$slug, $slug);
    }
});
