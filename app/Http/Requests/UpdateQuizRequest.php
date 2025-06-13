<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
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
        $quiz = $this->route('quiz');
        return [
            'title' => 'sometimes|required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:quizzes,slug,' . $quiz->id,
            ],
            'description' => 'nullable|string',
            'pass_percentage' => 'sometimes|required|numeric|min:0|max:100',
            'learning_provider_id' => 'nullable|exists:learning_providers,id',
        ];
    }
}
