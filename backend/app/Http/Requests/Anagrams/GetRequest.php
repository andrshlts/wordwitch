<?php

namespace App\Http\Requests\Anagrams;

use Illuminate\Foundation\Http\FormRequest;

class GetRequest extends FormRequest
{
    /**
     * Public endpoint - everyone is allowed to make this request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'word' => [
                'required',
                'string',
                'min:2',
                'max:50',
                'regex:/^[a-zA-Z0-9õäöüÕÄÖÜ\s-]+$/',
            ],
            'per_page' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],

            // This is not necessary as Laravel Pagination handles it
            // but added for completeness + protection of "Guesser" algorithm
            'page' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    /**
     * Custom error messages
     * @return array
     */
    public function messages(): array
    {
        return [
            'word.required' => __('validation.word.required'),
            'word.string' => __('validation.word.string'),
            'word.min' => __('validation.word.min', ['min' => 2]),
            'word.max' => __('validation.word.max', ['max' => 50]),
            'word.regex' => __('validation.word.regex'),
            'per_page.integer' => __('validation.per_page.integer'),
            'per_page.min' => __('validation.per_page.min', ['min' => 1]),
            'per_page.max' => __('validation.per_page.max', ['max' => 100]),
            'page.integer' => __('validation.page.integer'),
            'page.min' => __('validation.page.min', ['min' => 1]),
            'page.max' => __('validation.page.max', ['max' => 100]),
        ];
    }
}
