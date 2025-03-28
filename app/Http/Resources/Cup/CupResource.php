<?php

namespace App\Http\Resources\Cup;

use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @property integer    $id
 * @property string     $name
 * @property string     $region
 * @property string     $stages
 * @property integer    $year
 * @property array      $image
 * @property array      $color
 */
class CupResource extends JsonResource
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
            'year'      => $this->year,
            'stages'    => $this->stages,
            'image'    => $this->image,
            'color'    => $this->color,
            'user'      => UserResource::make($this->whenLoaded('user')),
            'location'  => LocationResource::make($this->whenLoaded('location')),
        ];
    }
}
