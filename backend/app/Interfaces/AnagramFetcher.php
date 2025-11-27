<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface AnagramFetcher
{

    // SOLID principle - a controller can use any implementation of this interface

    /**
     * Fetch an array of anagrams for a given word
     * 
     * @param string $word
     * @param int $perPage
     * @param ?int $page
     * @return LengthAwarePaginator
     */
    public function getAnagrams(string $word, int $perPage, ?int $page = 1): LengthAwarePaginator;

}