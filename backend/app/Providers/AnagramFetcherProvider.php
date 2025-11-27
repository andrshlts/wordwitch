<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\AnagramFetcher;
use App\Services\Anagrams\KeyAnagramFetcher;
use App\Services\Anagrams\GuessAnagramFetcher;

class AnagramFetcherProvider extends ServiceProvider
{
    /**
     * Register bindings.
     */
    public $bindings = [
        AnagramFetcher::class => KeyAnagramFetcher::class,
        // AnagramFetcher::class => GuessAnagramFetcher::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }
}