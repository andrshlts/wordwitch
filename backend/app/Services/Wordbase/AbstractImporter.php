<?php

namespace App\Services\Wordbase;

use Illuminate\Support\Facades\DB;
use App\Interfaces\WordImporter;

abstract class AbstractImporter implements WordImporter
{
    /**
     * Import wordbase to application database
     * Concrete classes must implement this
     */
    abstract public function import(): void;

    /**
     * Clear anagram cache
     */
    public function clearCache(): void
    {
        $prefix = config('cache.prefix') ?: '';

        DB::table('cache')
            ->where('key', 'like', "$prefix%get_anagrams_%")
            ->delete();
    }
}
