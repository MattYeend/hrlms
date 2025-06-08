<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLearningProviderRequest extends FormRequest
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
        $learningProvider = $this->route('learningProvider');

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:learning_providers,slug,' . $learningProvider->id,
            ],
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
