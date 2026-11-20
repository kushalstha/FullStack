<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

/**
 * REST API controller for courses.
 * Separate from any web controller so API and web logic stay apart.
 */
class CourseController extends Controller
{
    /**
     * GET /api/courses
     * Return all courses. Status: 200 OK (default).
     */
    public function index()
    {
        $courses = Course::all();

        // collection() wraps every course in CourseResource
        return CourseResource::collection($courses);
    }

    /**
     * POST /api/courses
     * Create a course. Status: 201 Created.
     * StoreCourseRequest validates the input before this method runs.
     */
    public function store(StoreCourseRequest $request)
    {
        // validated() returns only fields that passed validation
        $course = Course::create($request->validated());

        return (new CourseResource($course))
            ->response()
            ->setStatusCode(201); // 201 = resource created
    }

    /**
     * GET /api/courses/{course}
     * Return one course. Status: 200 OK.
     * Route model binding finds the Course by id; missing id gives 404.
     */
    public function show(Course $course)
    {
        return new CourseResource($course);
    }

    /**
     * PUT/PATCH /api/courses/{course}
     * Update a course. Status: 200 OK.
     * UpdateCourseRequest validates the input before this method runs.
     */
    public function update(
        UpdateCourseRequest $request,
        Course $course
    ) {
        $course->update($request->validated());

        // fresh() reloads the model from the database so the response is current
        return new CourseResource($course->fresh());
    }

    /**
     * DELETE /api/courses/{course}
     * Delete a course. Status: 204 No Content (empty body).
     */
    public function destroy(Course $course): JsonResponse
    {
        $course->delete();

        return response()->json(null, 204);
    }
}