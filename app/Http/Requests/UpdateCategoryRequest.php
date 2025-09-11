<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        // يجيب الموديل المربوط من المسار
          $id = $this->route('category'); // هيرجع ID كـ int أو string

        return [
            'name'        => ['required','string','max:255'],
            'slug'        => [
                'nullable','string','max:255',
                Rule::unique('categories', 'slug')->ignore($id),
            ],
            'description' => ['nullable','string'],
            'status'      => ['nullable','boolean'],
        ];
    }
}
