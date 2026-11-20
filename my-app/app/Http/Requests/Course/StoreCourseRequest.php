<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates data when CREATING a course (POST /api/courses).
 */
class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Required, unique course name
            'name' => 'required|string|max:255|unique:courses,name',

            // Optional description
            'description' => 'nullable|string|max:1000',

            // Required whole number, at least 1 (e.g. weeks or months)
            'duration' => 'required|integer|min:1',

            // Required number, cannot be negative
            'fee' => 'required|numeric|min:0',

            // Required text (e.g. beginner, intermediate, advanced)
            'difficulty' => 'required|string|max:50',

            // Optional true/false. 'sometimes' = only validated if sent
            'is_active' => 'sometimes|boolean',
        ];
    }
}