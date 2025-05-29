<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->role_id === \App\Models\Role::SUPER_ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:companies,name,' . $this->route('company')->id,
            ],
            'first_line' => ['required', 'string'],
            'second_line' => ['nullable', 'string'],
            'town' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'county' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'postcode' => ['required', 'string'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'is_default' => ['boolean'],
            'slug' => ['nullable|unique:companies,slug'],
        ];
    }
}
