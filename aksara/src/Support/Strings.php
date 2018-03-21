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

    public function unslug($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
