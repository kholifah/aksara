<?php

function is_plugin_required($pluginName)
{
    return \PluginRequiredBy::isRequired($pluginName);
}

function get_plugin_required_by($pluginName)
{
    return \PluginRequiredBy::getRequiredBy($pluginName);
}

function can_disable_module($type, $moduleName)
{
    //TODO
    //check single backend
    if ($type == 'backend') {
        $backends = \ModuleRegistry::getActiveModuleByType('backend');
        if (count($backends) <= 1) {
            return false;
        }
    }

    $required = is_plugin_required($moduleName);
    if ($required) {
        return false;
    }

    return true;
}

function is_module_active($moduleName)
{
    return \ModuleRegistry::isActive($moduleName);
}
