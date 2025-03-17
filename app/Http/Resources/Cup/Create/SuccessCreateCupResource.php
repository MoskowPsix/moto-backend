<?php

namespace App\Http\Resources\Cup\Create;

use App\Http\Resources\Cup\CupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateCupResource extends JsonResource
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
            'message' => __('messages.cup.create.success'),
            'cup' => CupResource::make($this->resource)
        ];
    }
}
