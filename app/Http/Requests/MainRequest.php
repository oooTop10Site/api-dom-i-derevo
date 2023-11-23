<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data' => ['required', 'array'],

            'data.meta_title' => ['required', 'string', 'min:1'],
            'data.meta_description' => ['required', 'string', 'min:1'],
            'data.meta_keywords' => ['nullable', 'string', 'min:1'],

            'data.email' => ['nullable', 'email', 'string', 'min:1'],
            'data.phone' => ['nullable', 'string', 'min:1'],
            'data.address' => ['nullable', 'string', 'min:1'],
            'data.map' => ['nullable', 'string', 'min:1'],

            'data.about' => ['required', 'string', 'min:1'],
        ];
    }
}
