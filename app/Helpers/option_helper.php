<?php

use App\Models\Option;

// Function for delete data options
function delete_options($key = FALSE)
{
    // To function delete_options in option model
    $option = Option::delete_options($key);
    return $option;

}

// Function for get option data
function get_options($key = FALSE, $default = FALSE)
{
    // To function delete_options in model
    $option = Option::get_options($key, $default);

    return $option;
}

// Function for set option data
function set_options($key = FALSE, $value = FALSE)
{
    // To function delete_options in model
    $option = Option::set_options($key, $value);
    return $option;
}
