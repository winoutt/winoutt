<?php

namespace App\Services;

class MentionService
{
    public static function parseUsernames($word)
    {
        if (!$word) return collect();
        $regex = '/(@\w+)/';
        preg_match_all($regex, $word, $matches);
        $mentions = array_unique(array_merge(...$matches));
        $removeAtSign = function($mention) {
            return str_replace('@', '', $mention);
        };
        return collect(array_map($removeAtSign, $mentions));
    }
}