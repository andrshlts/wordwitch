<?php

namespace App\Services\Anagrams;

use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Interfaces\AnagramFetcher;
use App\Models\Word;

class GuessAnagramFetcher implements AnagramFetcher
{
    
    public function __construct() {}

    /**
     * Fetch an array of anagrams for a given word
     * Finds anagrams based on a guesser algorithm
     * 
     * This is a good example of what not to do in production
     * This is inefficient and slow for large datasets
     * 
     * This is only used as an example to demonstrate
     * the ease of swapping different anagram algorithms
     * 
     * @param string $word
     * @param int $perPage
     * @param ?int $page
     * @return LengthAwarePaginator
     */
    public function getAnagrams(string $word, int $perPage, ?int $page = 1): LengthAwarePaginator
    {
        // Prepare input
        $trimmed = Str::lower(trim($word, ' -'));
        $normalized = str_replace([' ', '-'], '', $trimmed);

        // Count letters
        $inputLength = \mb_strlen($normalized);
        $inputLetterCount = array_count_values(mb_str_split($normalized));

        // Fetch words of the same length
        $candidates = Word::query()
            ->selectRaw('LOWER(word) as word')
            ->whereRaw('CHAR_LENGTH(REPLACE(REPLACE(word, " ", ""), "-", "")) = ?', [$inputLength])
            ->whereRaw('LOWER(word) != ?', [$trimmed])
            ->get();

        // Filter by matching letter counts
        $anagrams = $candidates->filter(function (Word $candidate) use ($inputLetterCount) {
            $normalizedCandidate = Str::lower(str_replace([' ', '-'], '', $candidate->word));
            return array_count_values(mb_str_split($normalizedCandidate)) == $inputLetterCount;
        })->sortBy('word')->values();

        // Pagination
        return new LengthAwarePaginator(
            items: $anagrams->forPage($page, $perPage),
            total: $anagrams->count(),
            perPage: $perPage,
            currentPage: $page,
        );
    }

}