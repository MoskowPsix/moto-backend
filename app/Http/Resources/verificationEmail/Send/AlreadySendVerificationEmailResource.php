<?php

namespace App\Http\Resources\verificationEmail\Send;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlreadySendVerificationEmailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'error',
            'message'   => __('messages.verification_email.send.already_sent'),
        ];
    }
}
