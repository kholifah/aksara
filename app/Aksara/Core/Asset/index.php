<?php

\App::singleton('enqueue', function () {
    return new \App\Aksara\Core\Asset\Enqueue();
});
