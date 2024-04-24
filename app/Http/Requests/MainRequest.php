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

            'data.email' => ['required', 'email', 'string', 'min:1'],
            'data.phone_1' => ['required', 'string', 'min:1'],
            'data.phone_2' => ['required', 'string', 'min:1'],
            'data.address' => ['required', 'string', 'min:1'],
            'data.short_address' => ['required', 'string', 'min:1'],
            'data.map' => ['nullable', 'string', 'min:1'],
            'data.map_link' => ['nullable', 'string', 'min:1'],
            'data.favicon' => ['nullable', 'image'],
            'data.logo' => ['nullable', 'image'],
            'data.politic' => ['required', 'string', 'min:1'],
        ];
    }
}
