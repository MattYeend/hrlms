<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
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
                'unique:companies,name',
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
            'is_active' => ['boolean'],
            'is_default' => ['boolean'],
        ];
    }
}
