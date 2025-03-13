<?php

namespace App\Http\Resources\Phone;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $number
 * @property int $last_num
 */
class PhoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number'    => $this->number,
            'last_num'  => $this->last_num,
        ];
    }
}
