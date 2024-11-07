<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'floor_title' => ['required', 'string', 'min:1', 'max:255'],
            'square' => ['required', 'integer'],
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'delete_images' => 'nullable|array',                      // Валидация массива удаляемых изображений
            'delete_images.*' => 'integer|exists:images,id', // Проверка, что каждый элемент массива - существующий id
        ];
    }
}
