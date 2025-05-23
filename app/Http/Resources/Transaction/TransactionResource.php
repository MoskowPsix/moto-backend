<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\Attendance\AttendanceResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer    $id
 * @property boolean    $status
 * @property string     $desc
 * @property integer    $count
 * @property integer    $user
 * @property string     $date
 * @property string     $link
 * @property array      $attendances
 */
class TransactionResource extends JsonResource
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
            'status'        => $this->status,
            'date'          => $this->date,
            'user'          => $this->whenLoaded('user', UserResource::make($this->user)),
            'attendances'    => $this->whenLoaded('attendances', AttendanceResource::collection($this->attendances)),
        ];
    }
}
