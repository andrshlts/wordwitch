<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WordbaseController;
use App\Http\Controllers\AnagramController;

Route::prefix('/v1')->group(function () {

    // Fetch wordbase to application database
    Route::put('/refreshWordbase', [WordbaseController::class, 'refresh']);

    // Find anagrams for given word - results are cached for 24 hours
    Route::get('/getAnagrams', [AnagramController::class, 'get']);

});