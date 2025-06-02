<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserJobRequest extends FormRequest
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
        $job = $this->route('job');

        $uniqueSlugRule = 'unique:user_jobs,slug,' . $job->id;
        $uniqueShortCodeRule = 'unique:user_jobs,short_code,' . $job->id;

        return [
            'job_title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $uniqueSlugRule],
            'short_code' => [
                'nullable', 'string', 'max:10', $uniqueShortCodeRule,
            ],
            'description' => ['nullable', 'string'],
            'is_default' => ['boolean'],
            'department_id' => ['exists:departments,id'],
        ];
    }
}
