<?php

namespace App\Http\Resources\Version\GetFirst;

use App\Http\Resources\Version\VersionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetFirstVersionResource extends JsonResource
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
            'message' => 'Последняя версия приложения получены успешно.',
            'version' => VersionResource::make($this->resource)
        ];
    }
}
