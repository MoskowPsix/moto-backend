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
 * @property integer    $attendance
 * @property string     $date
 * @property string     $link
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
            'desc'          => $this->desc,
            'count'         => $this->count,
            'date'          => $this->date,
            'user'          => $this->whenLoaded('user', UserResource::make($this->user)),
            'attendance'    => $this->whenLoaded('attendance', AttendanceResource::make($this->attendance)),
//            'attendance'    => AttendanceResource::collection($this->attendance),
        ];
    }
}
