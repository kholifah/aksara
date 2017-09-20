<?php
include "admin_helper.php";
include "option_helper.php";

function get_calback($callback)
{
  if (is_string($callback) && strpos($callback, '@')) {
    $callback = explode('@', $callback);
    return array(app( $callback[0]), $callback[1]);
  } else if (is_callable($callback)) {
    return $callback;
  } else {
    throw new Exception('$callback is not a Callable', 1);
  }
}

function aksara_slugify( $name )
{
  $name = basename($name);
  $name = strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1-$2', $name));

  return str_slug($name);
}

// @todo segment ada cms berarti admin
function is_admin()
{
    $segments = \Request::segments();
}
