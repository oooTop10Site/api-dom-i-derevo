<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InformationRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['nullable', 'min:1'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_h1' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_description' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'min:1', 'max:255'],
            'seo_keyword' => ['nullable', 'string', 'min:1', 'max:255', Rule::unique('informations', 'seo_keyword')->ignore($this->route('information.id'))],
        ];
    }
}
