<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Word;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    protected $model = Word::class;

    public function definition()
    {
        return [
            'word' => $this->faker->unique()->word(),
        ];
    }
}
