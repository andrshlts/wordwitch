<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\Word;

class AnagramControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_validates_missing_word()
    {
        $response = $this->getJson('/api/v1/getAnagrams');

        $response->assertStatus(422);
    }

    public function test_validates_short_word()
    {
        $response = $this->getJson('/api/v1/getAnagrams?word=a');
        $response->assertStatus(422);
    }

    public function test_validates_long_word()
    {
        $response = $this->getJson('/api/v1/getAnagrams?word=aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $response->assertStatus(422);
    }

    public function test_validates_invalid_characters()
    {
        $response = $this->getJson('/api/v1/getAnagrams?word=ä+0?2+1gk');

        $response->assertStatus(422);
    }

    public function test_validates_invalid_page()
    {
        $response_min = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=5&page=0');
        $response_min->assertStatus(422);

        $response_max = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=5&page=1001');
        $response_max->assertStatus(422);

        $response_type = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=5&page=esimene');
        $response_type->assertStatus(422);
    }

    public function test_validates_invalid_per_page()
    {
        $response_min = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=0');
        $response_min->assertStatus(422);

        $response_max = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=1000');
        $response_max->assertStatus(422);

        $response_type = $this->getJson('/api/v1/getAnagrams?word=sõna&per_page=kaks');
        $response_type->assertStatus(422);
    }

    public function test_respects_pagination()
    {
        Word::factory()->create(['word' => 'seeonpikkanagramm']);

        $words = ['seeonpikkanagramm'];

        while (\count($words) < 51) {
            $shuffled = str_shuffle('seeonpikkanagramm');
            if (!\in_array($shuffled, $words)) {
                $words[] = $shuffled;
                Word::factory()->create(['word' => $shuffled]);
            }
        }

        $response = $this->getJson('/api/v1/getAnagrams?word=seeonpikkanagramm&page=4&per_page=5');

        $response->assertStatus(200);
        $this->assertEquals(5, \count($response->json('data.anagrams')));
        $this->assertEquals(50, $response->json('data.meta.total'));
        $this->assertEquals(5, $response->json('data.meta.per_page'));
        $this->assertEquals(4, $response->json('data.meta.current_page'));
        $this->assertEquals(10, $response->json('data.meta.last_page'));
    }

    public function test_returns_paginated_anagrams()
    {
        Word::factory()->create(['word' => 'mono']);
        Word::factory()->create(['word' => 'moon']);
        Word::factory()->create(['word' => 'nomo']);
        Word::factory()->create(['word' => 'noom']);

        $response = $this->getJson('/api/v1/getAnagrams?word=mono&per_page=2&page=2');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'word' => 'mono',
                    'anagrams' => ['noom'],
                    'meta' => [
                        'total' => 3,
                        'per_page' => 2,
                        'current_page' => 2,
                        'last_page' => 2,
                    ],
                ],
            ]);
    }

    public function test_ignores_hyphens()
    {
        Word::factory()->create(['word' => 'ana-gramm']);
        Word::factory()->create(['word' => 'anagram-m']);
        Word::factory()->create(['word' => 'mmragana']);
        Word::factory()->create(['word' => 'raangamm']);

        $response = $this->getJson('/api/v1/getAnagrams?word=--ana-gramm');

        $response->assertStatus(200);
        $this->assertEquals(['anagram-m', 'mmragana', 'raangamm'], $response->json('data.anagrams'));
    }

    public function test_ignores_spaces()
    {
        Word::factory()->create(['word' => 'ana gramm']);
        Word::factory()->create(['word' => 'anagram m']);
        Word::factory()->create(['word' => 'mmragana']);
        Word::factory()->create(['word' => 'raangamm']);

        $response = $this->getJson('/api/v1/getAnagrams?word=ana%20gramm');

        $response->assertStatus(200);
        $this->assertEquals(['anagram m', 'mmragana', 'raangamm'], $response->json('data.anagrams'));
    }

    public function test_ignores_case()
    {
        Word::factory()->create(['word' => 'anagramm']);
        Word::factory()->create(['word' => 'AnagRmma']);
        Word::factory()->create(['word' => 'ANAGRMAM']);
        Word::factory()->create(['word' => 'AnARgAmm']);

        $response = $this->getJson('/api/v1/getAnagrams?word=anagrmma');

        $response->assertStatus(200);
        $this->assertEquals(['anagramm', 'anagrmam', 'anargamm'], $response->json('data.anagrams'));
    }

    public function test_respects_nordic()
    {
        Word::factory()->create(['word' => 'änägrõmm']);
        Word::factory()->create(['word' => 'änagrömm']);
        Word::factory()->create(['word' => 'anagromm']);
        Word::factory()->create(['word' => 'mmõrgänä']);

        $response = $this->getJson('/api/v1/getAnagrams?word=%C3%A4n%C3%A4gr%C3%B5mm');

        $response->assertStatus(200);
        $this->assertEquals(['mmõrgänä'], $response->json('data.anagrams'));
    }

}