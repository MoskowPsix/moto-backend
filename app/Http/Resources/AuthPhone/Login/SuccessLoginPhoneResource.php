<?php

namespace App\Http\Resources\AuthPhone\Login;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessLoginPhoneResource extends JsonResource
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
            'message' => __('messages.auth_phone.login.success'),
//            'phone' => $this->when(isset($this->resource), $this->resource)
        ];
    }
}
