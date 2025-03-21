<?php

namespace App\Http\Resources\FavoriteUser\Toggle;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessTogglrUserFavoriteResource extends JsonResource
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
            'message' => $this->resource? __('messages.favorite_user.toggle.success_add') : __('messages.favorite_user.toggle.success_remove'),
        ];
    }
}
