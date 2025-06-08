<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLearningProviderRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:learning_providers,slug',
            'business_type_id' => 'nullable|exists:business_types,id',
            'first_line' => 'required|string|max:255',
            'second_line' => 'nullable|string|max:255',
            'town' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postcode' => 'required|string|max:20',
            'main_email_address' => 'required|email|max:255',
            'first_phone_number' => 'required|string|max:20',
            'second_phone_number' => 'nullable|string|max:20',
            'person_to_contact' => 'required|string|max:255',
            'is_archived' => 'boolean',
        ];
    }
}
