<?php
namespace App\Modules\Plugins\PostType;
use App\Modules\Plugins\PostType\Repository\AksaraQuery;

class Permalink
{
    private $options = [ "{post-type}/{slug}",
                         "{post-date}/{slug}",
                         "{taxonomy-name[name]}/{term-name}/{slug}" ];
                         "{slug}" ];
    private $where = [];
    private $replace = [];

    public function __construct()
    {
        $registeredTaxonomies = \Config::get('aksara.post-type.taxonomies');
        foreach ($registeredTaxonomies as $taxonomy => $taxonomyArgs) {
            $this->replace['{taxonomy-name['.$taxonomy.']}'] = '{'.$taxonomyArgs['slug'].'}';
        }

        $this->replace['{post-type}'] = '{'.get_post_type_args('slug',$post->post_type).'}';
        $this->replace['{post-date}'] = '{year}/{month}';
        $this->replace['{term-name}'] = '{term}';

        $this->where['{year}'] = '\d+';
        $this->where['{month}'] = '\d+';
    }

    public function getOptions()
    {
        return $this->options;
    }


    public function getPostPermalinkFormat($postType)
    {
        $options = get_options('website_options', []);

        // get from options
        if( isset($options['permalink']) && isset($options['permalink'][$postType]) ) {
            return $options['permalink'][$postType];
        }

        // page and post special treatment for default value
        if( $postType == 'post' || $postType == 'page' )
            return $this->options[3];

        // default
        return $this->options[0];
    }

    public function getPostPermalinkURL($post)
    {

    }

    public function getPostPermalinkRoute($postType)
    {
        $format  = getPostPermalinkFormat($postType);

        foreach ( $this->replace as $pattern => $replace ) {
            $format = str_replace($pattern, $replace, $format);
        }

        return $format;
    }

    public function generatePostPermalinkRoute($postType)
    {
        $format = $this->getPostPermalinkRoute($postType);

        if( $format == "{slug}" ) {
            return false;
        }

        \Route::get( $postTypeArgs['slug'].'/{slug}', ['as' => 'aksara.post-type.front-end.single.'.$postType, 'uses' =>'\App\Modules\Plugins\PostType\Http\FrontEndController@serve']);

    }
}
