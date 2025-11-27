<?php

return [

    /**
     * We could potentially use these to translate validation errors.
     * This would require a language header in the request.
     * However, as we will not be showing these messages to end users,
     * we will keep them in English for simplicity.
     * The end users will receive generic error messages based on API response.
     * These messages will be provided by the frontend itself.
     */

    'word' => [
        'required' => '\'word\' is required.',
        'string' => '\'word\' must be a string.',
        'min' => '\'word\' must be at least :min characters.',
        'max' => '\'word\' may not be greater than :max characters.',
        'regex' => '\'word\' contains invalid characters.',
    ],

    'per_page' => [
        'integer' => '\'per_page\' must be an integer.',
        'min' => '\'per_page\' must be at least :min.',
        'max' => '\'per_page\' may not be greater than :max.',
    ],

    'page' => [
        'integer' => '\'page\' must be an integer.',
        'min' => '\'page\' must be at least :min.',
        'max' => '\'page\' may not be greater than :max.',
    ],

];