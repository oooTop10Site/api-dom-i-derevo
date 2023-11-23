<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'login' => ['required', 'string', 'min:1', 'max:255', Rule::unique('users', 'login')->ignore($this->route('user.id'))],
            'password' => [Rule::requiredIf($this->routeIs('user.store')), Rule::excludeIf(empty($this->password)), 'string', 'min:1', 'max:255', 'confirmed'],
            'name' => ['nullable', 'string', 'min:1', 'max:255'],
            'status' => ['required', 'boolean']
        ];
    }
}
