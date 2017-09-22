<?php
namespace App\Modules\Plugins\PostType\Model;

use App\Modules\Plugins\PostType\Model\Post;

class TermSlugObserver
{
    function saving($term)
    {
        $this->updateSlug($term);
    }

    function updating($term)
    {
        $this->updateSlug($term);
    }

    function updateSlug($term)
    {
        if( $term['slug'] !== null && $term['slug'] != '' )
        {
            $term['slug'] = str_slug($term['slug']);
        }
        else if( $term['name'] !== null && $term['name'] != '' )
        {
            $term['slug'] = str_slug($term['name']);
        }

        // No slug no term title, bail out
        if( $term['slug'] == '' )
            return;

        $counter = 0;
        $exist = true;

        while( $exist )
        {
            if( $counter != 0 )
            {
                $term['slug'] = $term['slug'].'-'.$counter;
            }

            $find = Term::where([
              'slug' => $term['slug'],
              'taxonomy_id' => $term['taxonomy_id']
            ])->first();

            //@TODO kalau sifatnya copy (autosave) perlu ditangani
            if( !$find || $find->id == $term['id'] )
                $exist = false;
            else
                $counter++;

        }
    }
}
