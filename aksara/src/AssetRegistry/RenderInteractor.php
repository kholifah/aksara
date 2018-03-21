<?php
namespace Aksara\AssetRegistry;

//TODO
//convert facade to injection for better testability
class RenderInteractor implements AssetRendererIntereface
{
    public function renderScript($location)
    {
        $config = \Config::get('aksara.assets', []);
        $enqueueScripts = $config[$location]['script'];

        // sort from priority
        ksort($enqueueScripts);

        foreach ($enqueueScripts as $position => $scripts) {
            foreach ($scripts as $script) {
                if (filter_var($script, FILTER_VALIDATE_URL)) {
                    echo '<script type="text/javascript" src="'.$script.'"></script>'."\n";
                }
            }
        }
    }

    public function renderStyle($location)
    {
        $config = \Config::get('aksara.assets', []);
        $enqueueStyles = $config[$location]['style'];

        // sort from priority
        ksort($enqueueStyles);

        foreach ($enqueueStyles as $position => $styles) {
            foreach ($styles as $style) {
                if (filter_var($style, FILTER_VALIDATE_URL)) {
                    echo '<link rel="stylesheet" type="text/css" href="'.$style.'">'."\n";
                }
            }
        }
    }
}
