<?php

namespace App\Http\Resources\Grade;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 */

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'user' => UserResource::make($this->whenLoaded('user')),
            'grade_parent'  => GradeResource::make($this->whenLoaded('gradeParent')),
            'grade_child'   => GradeResource::collection($this->whenLoaded('gradeChild')),
        ];
    }
}
