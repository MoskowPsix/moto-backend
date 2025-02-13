<?php

namespace App\Http\Resources\Grade\Create;

use App\Http\Resources\Grade\GradeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateGradeResource extends JsonResource
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
            'message' => __('messages.grade.create.success'),
            'grade' => GradeResource::make($this->resource)
        ];
    }
}
