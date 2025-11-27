<?php

namespace App\Services\Wordbase;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Services\Wordbase\AbstractImporter;
use App\Utility\Anagram as AnagramHelper;

class RemoteFileImporter extends AbstractImporter
{
    
    public function __construct(
        protected readonly string $url,
        protected readonly int $batchSize = 100,
    ) {}


    /**
     * Import wordbase to application database from remote .txt file
     * 
     * Reads file directly from remote source without creating a temporary file
     * This allows reading larger files in environments with limited memory or disk space
     * 
     * @return void
     */
    public function import(): void
    {
        $handle = fopen($this->url, 'r');
        if (!$handle) {
            throw new \RuntimeException("Failed to open URL: {$this->url}");
        }

        $batch = [];

        while (($line = fgets($handle)) !== false) {
            $word = preg_replace('/^[\s-]+|[\s-]+$/u', '', $line);
            if (\strlen($word) < 2) continue;

            $lowercase = Str::lower($word);
            if ($this->isRepeated($lowercase)) continue;

            $anagramKey = AnagramHelper::getAnagramKey($lowercase);

            $batch[] = ['word' => $lowercase, 'key' => $anagramKey];

            if (\count($batch) >= $this->batchSize) {
                $this->insertBatch($batch);
                $batch = [];
            }
        }

        if (!empty($batch)) {
            $this->insertBatch($batch);
        }

        fclose($handle);

        $this->clearCache();
    }

    /**
     * Insert a batch of words into db at once, ignore duplicates
     * 
     * @param array $batch - array of words, example: ['aabits','aabitsa'...]
     * @return void
     */
    protected function insertBatch(array $batch): void
    {
        DB::table('words')->insertOrIgnore($batch);
    }

    /**
     * Check if a word contains only one letter
     *
     * @param string $word
     * @return bool
     */
    protected function isRepeated(string $word): bool
    {
        $chars = mb_str_split($word);
        $uniqueChars = array_unique($chars);

        return \count($uniqueChars) === 1;
    }

}