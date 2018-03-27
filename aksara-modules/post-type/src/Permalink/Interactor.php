<?php

namespace Plugins\PostType\Permalink;

class Interactor implements PermalinkInterface
{
    private $options = [ "{post-type}/{slug}",
                         "{year}/{month}/{slug}",
                         "{taxonomy-name[name]}/{term-name}/{slug}",
                         "{slug}" ];

    private $where = [];
    private $replace = [];

    public function boot()
    {
        $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');
        foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
            $this->replace['{taxonomy-name['.$taxonomy.']}'] = $taxonomyArgs['slug'];
        }

        $this->replace['{term-name}'] = '{term}';

        \Route::pattern('year', '[0-9]+');
        \Route::pattern('month', '[0-9]+');
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getPermalink($post)
    {
        $postPermalink = $this->getPostPermalinkFormat($post->post_type);

        $postPermalink = \Eventy::filter('aksara.post-type.front-end.post-permalink.before',$postPermalink,$post);

        $postPermalink = str_replace("{post-type}", $post->post_type, $postPermalink);
        $postPermalink = str_replace("{slug}", $post->post_slug, $postPermalink);
        $postPermalink = str_replace("{year}", $post->post_date->format('Y'), $postPermalink);
        $postPermalink = str_replace("{month}", $post->post_date->format('m'), $postPermalink);
        $postPermalink = url($postPermalink);

        return \Eventy::filter('aksara.post-type.front-end.post-permalink.after',$postPermalink,$post);
    }

    public function getPostPermalinkRoutes($postType)
    {
        $format  = $this->getPostPermalinkFormat($postType);

        foreach ( $this->replace as $pattern => $replace ) {
            $format = str_replace($pattern, $replace, $format);
        }

        // replace post type
        $format = str_replace('{post-type}',get_post_type_args('slug',$postType),$format) ;
        return $format;
    }

    public function getPostPermalinkFormat($postType)
    {
        $postPermalinkFormat = "";
        $options = get_options('website_options', []);

        // get from options
        if( isset($options['permalink']) && isset($options['permalink'][$postType]) ) {
            $postPermalinkFormat = $options['permalink'][$postType];
        }
        // page and post special treatment for default value
        elseif( $postType == 'post' || $postType == 'page' ) {
            $postPermalinkFormat =  $this->options[3];
        }
        else {
            // default
            $postPermalinkFormat =  $this->options[0];
        }


        // filter and return
        return \Eventy::filter('aksara.post-type.front-end.post-permalink-format', $postPermalinkFormat);
    }
}

