<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates data when UPDATING a course (PUT/PATCH /api/courses/{course}).
 * Name uniqueness ignores the course being updated.
 */
class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Course model bound to the {course} route parameter
        $course = $this->route('course');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                // Unique name, except for this course's own row
                Rule::unique('courses', 'name')->ignore($course->id),
            ],
            'description' => 'nullable|string|max:1000',
            'duration' => 'required|integer|min:1',
            'fee' => 'required|numeric|min:0',
            'difficulty' => 'required|string|max:50',
            'is_active' => 'sometimes|boolean',
        ];
    }
}