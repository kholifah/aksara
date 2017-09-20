<?php
use App\Models\UserMeta;

// Function for delete user meta data
function delete_user_meta($userID = false, $key = false) 
{
    // To function delete_options in user meta model
    $user_meta = UserMeta::delete_user_meta($userID, $key);     
    return $user_meta;
}

// Function for get user meta data
function get_user_meta($userID = false, $key = false, $unserialize = false) 
{
    // To function get_user_meta in user meta model
    $user_meta = UserMeta::get_user_meta($userID, $key, $unserialize);
    return $user_meta;
}

// Function for setting user meta data
function set_user_meta($userID = false, $key = false, $value = false, $serialize = false) 
{
    // To function set_user_meta in user meta model
    $user_meta = UserMeta::set_user_meta($userID, $key, $value, $serialize);
    return $user_meta;
}
