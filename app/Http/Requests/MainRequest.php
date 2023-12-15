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
            'data.phone' => ['required', 'string', 'min:1'],
            'data.address' => ['required', 'string', 'min:1'],
            'data.short_address' => ['required', 'string', 'min:1'],
            'data.time' => ['required', 'string', 'min:1'],
            'data.additional_info' => ['nullable', 'string', 'min:1'],
            'data.map' => ['nullable', 'string', 'min:1'],
            'data.map_link' => ['nullable', 'string', 'min:1'],
            'data.vk' => ['nullable', 'string', 'min:1'],
            'data.telegram' => ['nullable', 'string', 'min:1'],
            'data.whatsapp' => ['nullable', 'string', 'min:1'],
            'data.politic' => ['required', 'string', 'min:1'],

            'data.about' => ['required', 'string', 'min:1'],
            'data.rating' => ['required', 'string', 'min:1'],

            'data.about_company' => ['required', 'string', 'min:1'],
            'data.company_name' => ['required', 'string', 'min:1'],
            'data.ur_company_name' => ['required', 'string', 'min:1'],
            'data.inn' => ['required', 'string', 'min:1'],
            'data.orgn' => ['required', 'string', 'min:1'],

            'data.favicon' => ['nullable', 'image'],
        ];
    }
}
