<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Defines the JSON shape returned for a Course.
 */
class CourseResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'duration' => $this->duration,

            // Model casts fee to "decimal:2" (a string like "1500.00").
            // (float) makes it a real JSON number.
            'fee' => (float) $this->fee,

            'difficulty' => $this->difficulty,

            // Cast to boolean in the model, so this is true/false
            'is_active' => $this->is_active,
        ];
    }
}