<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\Wordbase\RefreshRequest as RefreshWordbaseRequest;
use App\Interfaces\WordImporter;

class WordbaseController extends Controller
{

    /**
     * refresh
     *
     * Updates the application's wordbase by importing words from a defined source.
     * Can be used to populate an empty wordbase or refresh an existing one.
     * Utilizes the WordImporter service to handle the import process.
     * 
     * Utilizes SOLID DIP - WordImporter interface is injected, allowing for flexible implementations.
     *
     * @param RefreshWordbaseRequest $request
     * @param WordImporter $importer
     * @return JsonResponse
     */
    public function refresh(RefreshWordbaseRequest $request, WordImporter $importer): JsonResponse
    {
        $importer->import();

        return response()->json([
            'success' => true,
            'message' => 'Wordbase updated!',
        ], 200); // <- This could be improved as we could return 201 if the wordbase was empty before
    }

}
