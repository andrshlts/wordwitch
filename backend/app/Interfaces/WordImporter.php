<?php

namespace App\Interfaces;

interface WordImporter
{

    // SOLID principle - a controller can use any implementation of this interface

    /**
     * Import wordbase to application database
     * 
     * @return void
     */
    public function import(): void;

    /**
     * Clear anagram cache
     * 
     * @return void
     */
    public function clearCache(): void;

}