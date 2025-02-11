<?php

namespace App\Http\Resources\Grade\GetGradeForId;

use App\Http\Resources\Grade\GradeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetGradeForIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.grade.get_for_id.success'),
            'grade' => GradeResource::make($this->resource),
        ];
    }
}
