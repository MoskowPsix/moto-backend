<?php

namespace App\Http\Resources\Attendance;

use App\Http\Resources\Track\TrackResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer    $id
 * @property string     $name
 * @property string     $desc
 * @property numeric    $price
 * @property mixed      $track
*/
class AttendanceResource extends JsonResource
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
            'desc'      => $this->desc,
            'price'     => $this->price,
//            'track'     => $this->whenLoaded('track', TrackResource::make($this->track)),
        ];
    }
}
