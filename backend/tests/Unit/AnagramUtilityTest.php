<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Utility\Anagram as AnagramHelper;

class AnagramUtilityTest extends TestCase
{

    public function test_generates_basic_key()
    {
        $this->assertEquals(
            'aaagmmnr',
            AnagramHelper::getAnagramKey('anagramm')
        );
    }

    public function test_handles_spaces()
    {
        $this->assertEquals(
            'aaagmmnr',
            AnagramHelper::getAnagramKey('ana gramm')
        );
    }

    public function test_handles_hyphens()
    {
        $this->assertEquals(
            'aaagmmnr',
            AnagramHelper::getAnagramKey('ana-gramm')
        );
    }

    public function test_handles_case()
    {
        $this->assertEquals(
            'aaagmmnr',
            AnagramHelper::getAnagramKey('AnAGRamm')
        );
    }

    public function test_handles_nordic()
    {
        $this->assertEquals(
            'aagmmnrä',
            AnagramHelper::getAnagramKey('anägramm')
        );
    }

    public function test_handles_numbers()
    {
        $this->assertEquals(
            '1aaagmmnr',
            AnagramHelper::getAnagramKey('anagramm1')
        );
    }

    public function test_trims_word()
    {
        $this->assertEquals(
            'aaagmmnr',
            AnagramHelper::getAnagramKey('- ana-gramm   ')
        );
    }

}
