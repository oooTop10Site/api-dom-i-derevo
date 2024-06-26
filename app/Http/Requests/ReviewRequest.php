<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewRequest extends FormRequest
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
            'author' => ['required', 'string', 'min:1', 'max:255'],
            'text' => ['required', 'string', 'min:1'],
            'sort_order' => [Rule::excludeIf(request()->routeIs('api.review.store')), 'required', 'integer', 'min:0'],
            'status' => [Rule::excludeIf(request()->routeIs('api.review.store')), 'required', 'boolean'],
            'date_available' => [Rule::excludeIf(request()->routeIs('api.review.store')), 'required', 'date'],
        ];
    }
}
