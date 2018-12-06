<?php 
namespace App;

class StringHelper 
{
    public static function substrWithoutCuttingWords($string, $length = 200)
    {
        $string = html_entity_decode($string);
        if (strlen($string) < $length)
            return $string;

        $summary = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, ($length + 1)));
        return substr($summary, 0, $length) . '...';
    }
}