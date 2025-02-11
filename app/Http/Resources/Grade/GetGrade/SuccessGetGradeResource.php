<?php

namespace App\Http\Resources\Grade\GetGrade;

use App\Http\Resources\Grade\GradeResource;
use App\Models\Grade;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetGradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message'   => __('messages.grade.get.success'),
            'grades'     => $this->resource instanceof Grade ? GradeResource::make($this->resource) : GradeResource::collection($this->resource),
        ];
    }
}
