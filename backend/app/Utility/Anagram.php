<?php

namespace App\Utility;

use Illuminate\Support\Str;

class Anagram
{

    /**
     * Sanitize a word and reorder letters and
     * other characters alphabetically
     * 
     * DRY principle for anagram key generation
     * 
     * @param string $word
     * @return string
     */
    public static function getAnagramKey(string $word): string
    {
        $word = Str::lower(str_replace([' ', '-'], '', $word));
        $chars = mb_str_split($word);
        sort($chars);
        $key = implode('', $chars);

        return $key;
    }

}
