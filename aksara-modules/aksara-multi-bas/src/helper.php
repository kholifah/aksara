<?php
use App\Modules\Plugins\PostType\Model\PostMeta;
use App\Modules\Plugins\PostType\Model\Post;
use Plugins\AksaraMultiBas\TranslationEngine;

function get_registered_locales()
{
    return collect(json_decode(get_options('multibas_countries', "[]"),true));
}

function get_translated_post($post, $lang)
{
    $translationEngine = new TranslationEngine();
    return $translationEngine->getTranslatedPost($post,$lang);
}

function get_post_language($post)
{
    $postMeta = PostMeta::where('post_id', $post->id)
                            ->where('meta_key','like','multibas-translation-%')
                            ->first();
    if( !$postMeta ) {
        return get_multibas_default_locale();
    }

    return str_replace("multibas-translation-", "", $postMeta->meta_key);
}

function set_multibas_language($lang=false)
{
    $languageSwitcher = \App::make('Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->setLanguage($lang);
}

function get_current_multibas_locale()
{
    $languageSwitcher = \App::make('Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->getCurrentLocale();
}

function is_default_multibas_locale($lang = false)
{
    $languageSwitcher = \App::make('Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->isDefaultLocale($lang);
}
function get_multibas_default_locale()
{
    $languageSwitcher = \App::make('Plugins\AksaraMultiBas\LocaleSwitcher');
    return $languageSwitcher->getDefaultLocale();
}

/**
 * TODO
 *
 * move methods defined in action filters here
 * note for v2: if too many functions here, can be moved to another file and load it with file autoload
 * for v1: pretty much stuck here, included file is hardcoded for helper.php
 */

// metabox
//
function render_metabox_multibas($post)
{
    $postLists = [];
    $languages = get_registered_locales();

    if( get_post_meta($post->id,'is_translation') ) {
        $originalPost = \App\Modules\Plugins\PostType\Model\PostMeta::where('meta_key','like','multibas-translation-%')
                                                                        ->where('post_id','=',$post->id)
                                                                        ->first();
        $post = \App\Modules\Plugins\PostType\Model\Post::where('id',$originalPost->meta_value)->first();
    }

    foreach ( $languages as $language ) {
        $postList = [];
        $postList['language'] = $language;
        $postList['post'] = $language['default'] ? $post : get_translated_post($post,$language['language_code']);

        array_push($postLists,$postList);
    }

    echo view('aksara-multi-bas::metabox', compact('postLists','post'))->render();
}

//query-filter
//
function multibas_table_index_exclude_translation($query)
{
    $query->addQuery(function($query){
        $query = $query->whereNotIn('id',function($query){
            $query->select('post_id as id')
                  ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                  ->where('meta_key', 'is_translation');
        });

        return $query;
    });

    return $query;
}

function multibas_get_translated_post_frontpage($query)
{
    // Return original post if the current locale is default OR there is no language defined
    if(is_default_multibas_locale() || !get_multibas_default_locale()) {
        $query->addQuery(function($query){
            $query = $query->whereNotIn('id',function($query){
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'is_translation');
            });

            return $query;
        });
    }
    else {
        $locale = get_current_multibas_locale();
        $query->addQuery(function($query) use ($locale) {
            $query = $query->whereIn('id',function($query) use ($locale) {
                $query->select('post_id as id')
                      ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
                      ->where('meta_key', 'multibas-translation-'.$locale);
            });

            return $query;
        });
    }

    return $query;
}

function multibas_table_index_exclude_option_pages($query)
{
    $query = $query->whereNotIn('id',function($query){
        $query->select('post_id as id')
              ->from(with(new \App\Modules\Plugins\PostType\Model\PostMeta())->getTable())
              ->where('meta_key', 'is_translation');
    });

    return $query;
}

function multibas_column($cols, $postType) {

    $languages = get_registered_locales();

    foreach( $languages as $language ) {
        insert_after_array_key($cols, 'title',
            [ ' multibas-locale-'.$language['locale'].' multibas-'.$language['language_code'] => ['title'=>'<span class="flag-icon flag-icon-'.$language['flag_code'].'"></span>','class'=>"multibas-column no-sort",'width'=>'25px']]
        );
    }

    return $cols;
}

function multibas_row($colsId, $post) {
    if( !str_contains($colsId,'multibas') ) {
        return;
    }

    $languages = get_registered_locales();

    // Separate them multibas class on the column
    $colsId = explode(' ', $colsId);

    $locale = $colsId[1];
    $locale = str_replace("multibas-locale-", "", $locale);


    $lang = $colsId[2];
    $lang = str_replace("multibas-", "", $lang);


    foreach( $languages as $language ) {
        if( $locale == $language['locale'] ) {
            if( $language['default'] == true) {
                echo '<td class="multibas-column" ><span class="glyphicon glyphicon-ok" ></span></td>';
            }
            else {
                 $translatedPost = get_translated_post($post, $language['language_code']);

                 if( $translatedPost ) {
                     echo '<td class="multibas-column"><a href="'.route('admin.'.get_current_post_type_args('route').'.edit', $translatedPost->id).'" class="glyphicon glyphicon-pencil" ></a></td>';
                 }
                 else {
                     echo '<td class="multibas-column"><a class="glyphicon glyphicon-plus" href="'.route('aksara-multibas-generate-translation', ['postId'=>$post->id, 'lang'=>$lang]).'"></a></td>';
                 }
            //
            }
        }
    }
}
