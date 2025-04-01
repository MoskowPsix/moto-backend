<?php

namespace App\Http\Resources\Command\GetCoachesForAll;

use App\Http\Resources\User\UserWithFIOResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCoachesForAllCommandResource extends JsonResource
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
            'message'   => __('messages.command.get_coaches_for_all.success'),
            'coaches' => $this->resource instanceof User ? UserWithFIOResource::make($this->resource) : UserWithFIOResource::collection($this->resource),
        ];
    }
}
