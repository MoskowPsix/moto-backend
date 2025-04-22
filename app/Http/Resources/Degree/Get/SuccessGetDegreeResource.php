<?php

namespace App\Http\Resources\Degree\Get;

use App\Http\Resources\Degree\DegreeResource;
use App\Models\Degree;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetDegreeResource extends JsonResource
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
            'message'   => __('messages.degree.get.success'),
            'degree'    => $this->resource instanceof Degree ? DegreeResource::make($this->resource) : DegreeResource::collection($this->resource)
        ];
    }
}
