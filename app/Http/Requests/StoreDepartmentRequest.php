<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->role_id === \App\Models\Role::SUPER_ADMIN ||
               auth()->user()?->role_id === \App\Models\Role::ADMIN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:departments,slug',
            ],
            'description' => ['nullable', 'string'],
            'is_default' => ['boolean'],
            'dept_lead' => [
                'exists:users,id',
            ],
        ];
    }
}
