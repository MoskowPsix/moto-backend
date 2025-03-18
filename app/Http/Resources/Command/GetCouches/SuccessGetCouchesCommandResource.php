<?php

namespace App\Http\Resources\Command\GetCouches;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCouchesCommandResource extends JsonResource
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
            'message' => __('messages.couches.get.success'),
            'couches' => $this->resource instanceof User ? UserWithFIOResource::make($this->resource) : UserWithFIOResource::collection($this->resource),
        ];
    }
}
