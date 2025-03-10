<?php

namespace App\Http\Resources\Track;

use App\Http\Resources\Level\LevelResource;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property mixed $point
 * @property array $images
 * @property object $level
 * @property string $desc
 * @property integer $length
 * @property integer $turns
 * @property boolean $free
 * @property boolean $is_work
 * @property array $spec
 * @property mixed $location
 * @property boolean $light
 * @property boolean $season
 * @property string $schema_img
 * @property string $logo
 * @property array $contacts
 * @property mixed $store
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
            'images'    => $this->images,
            'latitude'  => !empty(json_decode($this->point)->coordinates) ? json_decode($this->point)->coordinates[0] : 0,
            'longitude' => !empty(json_decode($this->point)->coordinates) ? json_decode($this->point)->coordinates[1] : 0,
            'level'     => $this->whenLoaded('level', LevelResource::make($this->level)),
            'desc'      => $this->desc,
            'length'    => $this->length,
            'turns'     => $this->turns,
            'free'      => $this->free,
            'is_work'   => $this->is_work,
            'spec'      => $this->spec,
            'contacts'  => $this->contacts,
            'user'      => UserResource::make($this->whenLoaded('user')),
            'location'  => $this->whenLoaded('location', LocationResource::make($this->location)),
            'light'     => $this->light,
            'season'    => $this->season,
            'schema_img' => $this->schema_img,
            'logo'      => $this->logo,
            'store'     => $this->whenLoaded('store', StoreResource::make($this->store)),
        ];
    }
}
