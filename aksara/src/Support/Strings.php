<?php
namespace Aksara\Support;

use Illuminate\Support\Str;

class Strings
{
    public function slug($string, $separator = '-', $language = 'en')
    {
        $string = basename($string);
        $string = strtolower(
            preg_replace([
                '/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1-$2', $string));

        return Str::slug($string, $separator, $language);
    }

    public function slugToCamel($slug, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $slug)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }

    public function slugToTitle($slug)
    {
        $str = ucwords(str_replace('-', ' ', $slug));
        $str[0] = strtoupper($str[0]);
        return $str;
    }

    public function snakeToCamel($snake)
    {
        return str_replace('_', '', ucwords($snake, '_'));
    }
}
