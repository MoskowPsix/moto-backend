<?php

namespace App\Http\Resources\Race;

use App\Http\Resources\AppointmentCount\AppointmentCountResource;
use App\Http\Resources\Cup\CupResource;
use App\Http\Resources\Grade\GradeResource;
use App\Http\Resources\Location\LocationResource;
use App\Http\Resources\Status\StatusResource;
use App\Http\Resources\Store\StoreResource;
use App\Http\Resources\Track\TrackResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserWithFIOResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $desc
 * @property boolean $is_work
 * @property array $images
 * @property array $appointmentCount
 * @property bool $appointments_exists
 * @property string $date_start
 * @property object $contacts
 * @property string $position_file
 * @property string $results_file
 * @property string $pdf_files
 * @property string $record_end
 * @property string $record_start
 * @property bool $favourites_user_exists
 * @property bool $commissions_exists
 * @property array $store
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
            'id'                    => $this->id,
            'name'                  => $this->name,
            'desc'                  => $this->desc,
            'is_work'               => $this->is_work,
            'date_start'            => $this->date_start,
            'images'                => $this->images,
            'contacts'              => $this->contacts,
            'record_end'            => $this->record_end,
            'record_start'          => $this->record_start,
            'track'                 => TrackResource::make($this->whenLoaded('track')),
            'user'                  => UserResource::make($this->whenLoaded('user')),
            'appointment_count'     => AppointmentCountResource::make($this->whenLoaded('appointmentCount')),
            'appointments_exists'   => $this->when(isset($this->appointments_exists), $this->appointments_exists),
            'commissions_exists'    => $this->when(isset($this->commissions_exists), $this->commissions_exists),
            'favorite_exists'       => $this->when(isset($this->favourites_user_exists), $this->favourites_user_exists),
            'position_file'         => $this->position_file,
            'results_file'          => $this->results_file,
            'pdf_files'             => $this->pdf_files,
            'location'              => LocationResource::make($this->whenLoaded('location')),
            'grades'                => GradeResource::collection($this->whenLoaded('grades')),
            'status'                => StatusResource::make($this->whenLoaded('status')),
            'cups'                  => CupResource::collection($this->whenLoaded('cups')),
            'favorites_count'       => $this->whenLoaded('favoritesCount'),
            'commissions'            => UserWithFIOResource::collection($this->whenLoaded('commissions')),
            'store'         => $this->whenLoaded('store', StoreResource::make($this->store)),

        ];
    }
}
