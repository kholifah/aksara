<?php

namespace Aksara\Support;

class Arrays
{
    public function searchValueRecursive($needle, $haystack, $returnObject = true)
    {
        foreach ($haystack as $key => $value)
        {
            if ($key === $needle)
            {
                return $returnObject === true ? $value : true ;
            }
            elseif (is_array($value))
            {
                $result = $this->searchValueRecursive($needle, $value);
                if ($result !== false)
                    return $result;
            }
        }
        return false;
    }

    public function searchKeyRecursive($needle, $haystack, $returnObject = true)
    {
        foreach ($haystack as $key => $value)
        {
            if ($value === $needle)
            {
                return $returnObject === true ? $key : true ;
            }
            elseif (is_array($value))
            {
                $result = $this->searchKeyRecursive($needle, $value);
                if ($result !== false)
                    return $result;
            }
        }
        return false;
    }

    public function deleteRecursive(array $array, callable $callback)
    {
        foreach ($array as $key => $value)
        {
            if (is_array($value))
                $array[$key] = $this->deleteRecursive($value, $callback);
            else
                if ($callback($value, $key))
                    unset($array[$key]);
        }
        return $array;
    }

    public function insertAfterKey( &$array, $needle, $value = [])
    {
        $needleIndex  = array_search($needle, array_keys($array) );

        if( $needleIndex === false )
            return;

        $array = array_slice($array, 0, $needleIndex+1, true) +
            $value +
            array_slice($array, $needleIndex+1, count($array) - 1, true) ;
    }
}
