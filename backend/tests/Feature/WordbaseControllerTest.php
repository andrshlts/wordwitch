<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

use Tests\TestCase;
use App\Interfaces\WordImporter;

class WordbaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_updates_wordbase()
    {
        $this->mock(WordImporter::class, function ($mock) {
            $mock->shouldReceive('import')
                ->once()
                ->andReturnUsing(function () {
                    DB::table('words')->insert([
                        ['word' => 'anägramm', 'key' => 'aagmnnrä'],
                        ['word' => 'teine anagramm', 'key' => 'aaeegimmnnrtt'],
                    ]);
                });
        });

        $response = $this->putJson('/api/v1/refreshWordbase');
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Wordbase updated!',
            ]);

        $this->assertDatabaseHas('words', ['word' => 'anägramm', 'key' => 'aagmnnrä']);
        $this->assertDatabaseHas('words', ['word' => 'teine anagramm', 'key' => 'aaeegimmnnrtt']);
        $this->assertDatabaseCount('words', 2);
    }

}