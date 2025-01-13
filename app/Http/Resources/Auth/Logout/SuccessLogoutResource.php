<?php

namespace App\Http\Resources\Auth\Logout;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessLogoutResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'        => 'success',
            'message'       => __('messages.auth.logout.success'),
        ];
    }
}
