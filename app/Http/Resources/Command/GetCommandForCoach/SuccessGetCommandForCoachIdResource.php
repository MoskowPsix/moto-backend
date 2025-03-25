<?php

namespace App\Http\Resources\Command\GetCommandForCoach;

use App\Http\Resources\Command\CommandResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCommandForCoachIdResource extends JsonResource
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
            'message' => __('messages.command.get_for_coach_id.success'),
            'command' => $this->resource instanceof CommandResource ? CommandResource::make($this->resource) : CommandResource::collection($this->resource),
        ];
    }
}
