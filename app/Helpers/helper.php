<?php
include "admin_helper.php";
include "option_helper.php";

function get_calback($callback)
{
    if (is_string($callback) && strpos($callback, '@'))
    {
        $callback = explode('@', $callback);

        if( !class_exists($callback[0]) )
            throw new Exception($callback[0].'@'.$callback[1].' is not a Callable', 1);

        return array(app( $callback[0]), $callback[1]);
    }
    else if (is_callable($callback))
    {
        return $callback;
    }
    else
    {
        throw new Exception($callback.' is not a Callable', 1);
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

function insert_after_array_key( &$array, $needle, $value = [])
{
    $needleIndex  = array_search($needle, array_keys($array) );

    if( $needleIndex === false )
        return;

    // dd($array);
        // dd(array_slice($array, 0, 1, true));

    $array = array_slice($array, 0, $needleIndex+1, true) +
            $value +
            array_slice($array, $needleIndex+1, count($array) - 1, true) ;
    // dd(array_slice($array, $needleIndex+1, count($array) - 1, true));
}

// search value for given key
function array_search_value_recursive($needle, $haystack, $returnObject = true)
{
    foreach ($haystack as $key => $value)
    {
        if ($key === $needle)
        {
            return $returnObject === true ? $value : true ;
        }
        elseif (is_array($value))
        {
            $result = array_search_value_recursive($needle, $value);
            if ($result !== false)
                return $result;
        }
    }
    return false;
}
// search key for given value
function array_search_key_recursive($needle, $haystack, $returnObject = true)
{
    foreach ($haystack as $key => $value)
    {
        if ($value === $needle)
        {
            return $returnObject === true ? $key : true ;
        }
        elseif (is_array($value))
        {
            $result = array_search_key_recursive($needle, $value);
            if ($result !== false)
                return $result;
        }
    }
    return false;
}

function array_delete_recursive(array $array, callable $callback)
{
    foreach ($array as $key => $value)
    {
        if (is_array($value))
            $array[$key] = array_delete_recursive($value, $callback);
        else
            if ($callback($value, $key))
                unset($array[$key]);
    }
    return $array;
}
