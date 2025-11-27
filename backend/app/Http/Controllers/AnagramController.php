<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

use App\Http\Requests\Anagrams\GetRequest as GetAnagramsRequest;
use App\Interfaces\AnagramFetcher;
use App\Dtos\GetAnagramsData;

class AnagramController extends Controller
{

    /**
     * getAnagrams
     *
     * Retrieves a paginated array of anagrams from the database for the provided word.
     * Utilizes the AnagramFetcher service to perform the lookup and pagination.
     * 
     * Caches results for 24 hours to optimize performance for repeated requests.
     * 
     * Utilizes SOLID DIP - AnagramFetcher interface is injected, allowing for flexible implementations.
     *
     * @param GetAnagramsRequest $request
     * @param AnagramFetcher $anagramFetcher
     * @return JsonResponse
     */
    public function get(GetAnagramsRequest $request, AnagramFetcher $anagramFetcher): JsonResponse
    {
        $data = GetAnagramsData::fromRequest(request: $request);

        // Could md5 this but left it like this for ease of debugging if needed
        $cacheKey = "get_anagrams_{$data->word}_{$data->page}_{$data->perPage}";
    
        // Cached for 24 hours
        $anagrams = Cache::remember($cacheKey, now()->addDay(), fn () =>
            $anagramFetcher->getAnagrams(
                word: $data->word,
                perPage: $data->perPage,
                page: $data->page,
            )
        );

        return response()->json([
            'success' => true,
            'data' => [
                'word' => $data->word,
                'anagrams' => $anagrams->getCollection()->pluck('word')->values(),
                'meta' => [
                    'total' => $anagrams->total(),
                    'per_page' => $anagrams->perPage(),
                    'current_page' => $anagrams->currentPage(),
                    'last_page' => $anagrams->lastPage(),
                ],
            ],
        ], 200);
    }

}
