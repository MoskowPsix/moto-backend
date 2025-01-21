<?php

namespace App\Http\Resources\Race;

use App\Http\Resources\Track\TrackResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property boolean $is_work
 * @property string $date_star
 * @property array $images
 */
class RaceResource extends JsonResource
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
            'name'          => $this->name,
            'desc'          => $this->desc,
            'is_work'       => $this->is_work,
            'date_start'    => $this->date_star,
            'images'        => $this->images,
            'track'         => TrackResource::make($this->whenLoaded('track')),
            'user'          => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
