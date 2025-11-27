<?php

namespace App\Dtos;

use Illuminate\Support\Str;
use App\Http\Requests\Anagrams\GetRequest as GetAnagramsRequest;

class GetAnagramsData
{
    public function __construct(
        public string $word,
        public int $perPage,
        public int $page,
    ) {
        $this->word = Str::lower(trim($this->word, ' -'));
    }

    public static function fromRequest(GetAnagramsRequest $request): self
    {
        return new self(
            word: $request->validated('word'),
            perPage: $request->validated('per_page') ?? 10,
            page: $request->validated('page') ?? 1,
        );
    }
}