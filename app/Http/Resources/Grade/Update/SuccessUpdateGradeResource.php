<?php

namespace App\Http\Resources\Grade\Update;

use App\Http\Resources\Grade\GradeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateGradeResource extends JsonResource
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
            'message' => __('messages.grade.update.success'),
            'grade' => GradeResource::make($this->resource),
        ];
    }
}
