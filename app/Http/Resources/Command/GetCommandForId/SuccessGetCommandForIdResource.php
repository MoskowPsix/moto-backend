<?php

namespace App\Http\Resources\Command\GetCommandForId;

use App\Http\Resources\Command\CommandResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCommandForIdResource extends JsonResource
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
            'message' => __('messages.command.get_for_id.success'),
            'command' => CommandResource::make($this->resource),
        ];
    }
}
