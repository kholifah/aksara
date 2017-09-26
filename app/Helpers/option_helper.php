<?php

use App\Models\Option;

/**
 * Delete option by key
 * @param  string $key Option key
 * @return boolean     true or false
 */
function delete_options($key = false)
{
    // To function delete_options in option model
    $option = Option::delete_options($key);
    return $option;

}

/**
 * Get options by key
 * @param  string $key     Option key
 * @param  mixed $default  Default value if key not found
 * @return mixed           Option value
 */
function get_options($key = false, $default = false)
{
    // To function delete_options in model
    $option = Option::get_options($key, $default);

    return $option;
}

/**
 * Set options
 * @param  string $key  Option key
 * @param  mixed $value Option value
 * @return boolean      true or false
 */
function set_options($key = false, $value = false)
{
    // To function delete_options in model
    $option = Option::set_options($key, $value);
    return $option;
}
