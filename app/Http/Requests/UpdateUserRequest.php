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
    * Combines rules from basic user info, address, and employment sections.
    * Uses the route-bound user ID (if available) to exclude the current user's
    * email and slug from uniqueness validation.
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

    /**
     * Validation rules for basic user information.
     *
     * @param int|string|null $userId The current user's ID, used to ignore them in unique checks.
     * @return array<string, mixed> The rules for title, name, email, password, and slug.
     */
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

    /**
     * Validation rules for user address fields.
     *
     * @return array<string, mixed> The rules for address-related fields like post code, city, and country.
     */
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

    /**
     * Validation rules for employment-related fields.
     *
     * @return array<string, mixed> The rules for employment type and related foreign keys.
     */
    private function employmentRules(): array
    {
        return [
            'full_time' => ['sometimes', 'required', 'boolean'],
            'part_time' => ['sometimes', 'required', 'boolean'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'job_id' => ['nullable', 'exists:user_jobs,id'],
        ];
    }
}
