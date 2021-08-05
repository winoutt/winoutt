<?php

namespace App\Services;

class HashtagService
{
    public static function parseHashtags($word)
    {
        if (!$word) return collect();
        $regex = '/(#\w+)/';
        preg_match_all($regex, $word, $matches);
        $hashtags = array_unique(array_merge(...$matches));
        $removeHashSign = function($mention) {
            return str_replace('#', '', $mention);
        };
        return collect(array_map($removeHashSign, $hashtags));
    }
}