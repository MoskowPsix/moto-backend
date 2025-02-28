<?php

namespace App\Http\Resources\RecoveryPassword\Recovery;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessRecoveryRecoveryPasswordResource extends JsonResource
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
            'message' => __('messages.recovery_password.recovery.success'),
        ];
    }
}
