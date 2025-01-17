<?php

namespace App\Http\Resources\Track;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property mixed $point
 */
class TrackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'address'   => $this->address,
//            'latitude' => !empty(json_decode($this->point)->coordinates) ? json_decode($this->point)->coordinates[0] : 0,
//            'longitude' => !empty(json_decode($this->point)->coordinates) ? json_decode($this->point)->coordinates[1] : 0
        ];
    }
}
