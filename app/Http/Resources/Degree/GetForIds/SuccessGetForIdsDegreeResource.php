<?php

namespace App\Http\Resources\Degree\GetForIds;

use App\Http\Resources\Degree\DegreeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetForIdsDegreeResource extends JsonResource
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
            'message' => __('messages.degree.get_for_ids.success'),
            'degree' => DegreeResource::make($this->resource),
        ];
    }
}
