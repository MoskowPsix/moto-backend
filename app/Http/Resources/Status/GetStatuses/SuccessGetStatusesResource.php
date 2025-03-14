<?php

namespace App\Http\Resources\Status\GetStatuses;

use App\Http\Resources\Status\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetStatusesResource extends JsonResource
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
            'message' => __('messages.status.get_all.success'),
            'statuses' => $this->resource instanceof Status ? StatusResource::make($this->resource) : StatusResource::collection($this->resource),
        ];
    }
}
