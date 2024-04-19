<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'categories' => ['nullable', 'array'],
            'categories.*.category_id' => ['required', 'integer', Rule::exists('service_categories', 'id')],
            'services' => ['nullable', 'array'],
            'services.*.additional_service_id' => ['required', 'integer', Rule::exists('services', 'id')],
            'name' => ['required', 'string', 'min:1', 'max:255'],

            'price' => ['required', 'array'],
            'price.full' => ['required', 'decimal:0,2', 'min:0'],
            'price.*' => ['nullable', 'decimal:0,2', 'min:0'],

            'description' => ['nullable', 'min:1'],
            'preview' => ['nullable', 'min:1', 'max:255'],

            'additional_info' => ['nullable', 'array'],
            'additional_info.house' => ['nullable', 'array'],
            'additional_info.house.*' => ['nullable', 'string', 'min:1'],
            'additional_info.site' => ['nullable', 'array'],
            'additional_info.site.*' => ['nullable', 'string', 'min:1'],
            'additional_info.communication' => ['nullable', 'array'],
            'additional_info.communication.*' => ['nullable', 'boolean'],
            'additional_info.location' => ['nullable', 'array'],
            'additional_info.location.*' => ['nullable', 'string', 'min:1'],

            'image' => ['nullable', 'image'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_h1' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_description' => ['nullable', 'string', 'min:1', 'max:255'],
            'meta_keywords' => ['nullable', 'string', 'min:1', 'max:255'],
            'seo_keyword' => ['nullable', 'string', 'min:1', 'max:255', Rule::unique('services', 'seo_keyword')->ignore($this->route('service.id'))],
        ];
    }
}
