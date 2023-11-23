<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeedbackRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'min:1', 'max:255'],
            'phone' => ['required', 'string', 'min:1', 'max:255'],
            'text' => ['nullable', 'string', 'min:1'],
            'url' => ['required', 'string', 'min:1', 'max:255'],
            'status' => [Rule::excludeIf(request()->routeIs('api.feedback.store')), 'required', 'boolean'],
        ];
    }
}
