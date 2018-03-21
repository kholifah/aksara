<?php

// modify post ordering
\Eventy::addAction('aksara.admin.init-completed', function () {
    $postTypes = \Config::get('aksara.post-type.post-types');
    $languages = get_registered_locales();

    foreach ($postTypes as $postType => $args) {
            \Eventy::addFilter('aksara.post-type.'.$postType.'.index.table.column', 'multibas_column', 1, 2);
            \Eventy::addAction('aksara.post-type.'.$postType.'.index.table.row', 'multibas_row', 1, 2);
    }
});

