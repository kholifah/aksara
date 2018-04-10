<?php

function validate_theme_type($type)
{
    if (!in_array($type, ['backend', 'frontend'])) {
        throw new \Exception("Type parameter should be 'backend' or 'frontend'");
    }
}

function get_deactivate_themes($type)
{
    validate_theme_type($type);

    $activeBackends = get_active_module_by_type($type);
    $deactivates = [];
    for ($i = 0; $i < count($activeBackends)-1; $i++) {
        $deactivates[] = $activeBackends[$i];
    }
    return $deactivates;
}

function get_active_theme($type)
{
    validate_theme_type($type);

    $activeThemes = get_active_module_by_type($type);
    if (empty($activeThemes)) {
        return false;
    }
    //get last theme
    $theme = $activeThemes[count($activeThemes) - 1];
    return $theme;
}

function get_active_theme_name($type)
{
    validate_theme_type($type);
    $active = get_active_theme($type);
    if (!$active) {
        return false;
    }
    return $active->getName();
}

function get_active_theme_view($type, $view)
{
    $theme = get_active_theme_name($type);
    if (!$theme) {
        return false;
    }
    $customView = sprintf("%s::%s", $theme, $view);

    if (view()->exists($customView)) {
        return $customView;
    }
    return false;
}

function get_active_backend_view($view)
{
    return get_active_theme_view('backend', $view);
}

function get_active_frontend_view($view)
{
    return get_active_theme_view('frontend', $view);
}

function theme_view_exists($type, $view)
{
    $themeView = get_active_theme_view($type, $view);
    if (!$themeView) {
        return false;
    }
    return true;
}

function theme_view($type, $view, $data = [], $mergeData = [])
{
    $themeView = get_active_theme_view($type, $view);
    return view($themeView, $data, $mergeData);
}

function frontend_view_exists($view)
{
    return theme_view_exists('frontend', $view);
}

function frontend_view($view, $data = [], $mergeData = [])
{
    return theme_view('frontend', $view, $data, $mergeData);
}
