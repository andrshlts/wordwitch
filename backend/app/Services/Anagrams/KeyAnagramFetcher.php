<?php

namespace App\Services\Anagrams;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Interfaces\AnagramFetcher;
use App\Models\Word;
use App\Utility\Anagram as AnagramHelper;
use Str;

class KeyAnagramFetcher implements AnagramFetcher
{
    
    public function __construct() {}

    /**
     * Fetch an array of anagrams for a given word
     * Finds anagrams based on anagram key
     * 
     * @param string $word
     * @param int $perPage
     * @param ?int $page - unused, but kept for interface compatibility
     * @return LengthAwarePaginator
     */
    public function getAnagrams(string $word, int $perPage, ?int $page = 1): LengthAwarePaginator
    {
        $word = Str::lower(trim($word, ' -'));
        $anagramKey = AnagramHelper::getAnagramKey($word);

        return Word::query()
            ->where('key', $anagramKey)
            ->whereRaw('LOWER(word) != ?', [$word])
            ->selectRaw('LOWER(word) as word')
            ->orderByRaw('LOWER(word)')
            ->paginate($perPage);
    }

}