<?php

namespace App\Http\Requests\Wordbase;

use Illuminate\Foundation\Http\FormRequest;

class RefreshRequest extends FormRequest
{
    /**
     * Public endpoint - everyone is allowed to make this request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * No input, no rules
     */
    public function rules(): array
    {
        return [];
    }
}
