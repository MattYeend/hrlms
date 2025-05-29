<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')?->id ?? $this->user()->id;

        return array_merge(
            $this->basicInfoRules($userId),
            $this->addressRules(),
            $this->employmentRules()
        );
    }

    private function basicInfoRules(int|string|null $userId): array
    {
        return [
            'title' => ['nullable', 'string', 'max:10'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'email',
                Rule::unique('users', 'email')
                    ->ignore($userId),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'slug' => ['nullable', 'string', 'max:255',
                Rule::unique('users', 'slug')
                    ->ignore($userId),
            ],
        ];
    }

    private function addressRules(): array
    {
        return [
            'first_line' => ['sometimes', 'required', 'string', 'max:255'],
            'second_line' => ['nullable', 'string', 'max:255'],
            'post_code' => ['sometimes', 'required', 'string', 'max:20'],
            'town' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function employmentRules(): array
    {
        return [
            'full_time' => ['sometimes', 'required', 'boolean'],
            'part_time' => ['sometimes', 'required', 'boolean'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
        ];
    }
}
