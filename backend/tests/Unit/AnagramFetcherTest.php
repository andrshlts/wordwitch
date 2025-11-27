<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

use Tests\TestCase;
use App\Models\Word;

use App\Interfaces\AnagramFetcher;
use App\Services\Anagrams\KeyAnagramFetcher;
use App\Services\Anagrams\GuessAnagramFetcher;

class AnagramFetcherTest extends TestCase
{
    use RefreshDatabase;

    public static function fetcherProvider(): array
    {
        return [
            ['key', new KeyAnagramFetcher()],
            ['guess', new GuessAnagramFetcher()],
        ];
    }

    /**
     * This is deprecated in PHPUnit but Laravel doesn't support #[DataProvider] attribute yet
     * @dataProvider fetcherProvider
     */
    public function test_returns_correct_anagrams(string $name, AnagramFetcher $fetcher)
    {
        Word::factory()->create(['word' => 'anagramm']);
        Word::factory()->create(['word' => 'a nargamm']);
        Word::factory()->create(['word' => 'anargamm']);
        Word::factory()->create(['word' => 'agranamm']);
        Word::factory()->create(['word' => 'teine sõna']);
        Word::factory()->create(['word' => 'kolmas sõna']);

        $result = $fetcher->getAnagrams('anagramm', 5, 1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);

        $words = $result->pluck('word')->all();

        $this->assertEquals(['a nargamm','agranamm', 'anargamm'], $words);
        $this->assertEquals(3, $result->total());
    }

}