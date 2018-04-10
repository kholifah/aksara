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
    //get last theme
    $theme = $activeThemes[count($activeThemes) - 1];
    return $theme;
}

function get_active_theme_name($type)
{
    validate_theme_type($type);
    return get_active_theme($type)->getName();
}

function get_active_theme_view($type, $view)
{
    $backend = get_active_theme_name($type);
    $customView = sprintf("%s::%s", $backend, $view);

    if (view()->exists($customView)) {
        return $customView;
    } else {
        $defaultThemeConfig = config("aksara.default.$type");
        $defaultView = sprintf("%s::%s", $defaultThemeConfig, $view);
        return $defaultView;
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
