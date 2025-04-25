<?php

namespace App\Http\Resources\Store;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int    $id
 * @property string $login
 * @property string $password_1
 * @property string $password_2
 * @property string $token
 * @property mixed  $user
 */
class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
//            'login'         => $this->login,
//            'password_1'    => $this->password_1,
//            'password_2'    => $this->password_2,
//            'token'         => $this->token,
            'user'          => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
