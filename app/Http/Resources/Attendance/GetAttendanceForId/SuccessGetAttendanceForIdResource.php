<?php

namespace App\Http\Resources\Attendance\GetAttendanceForId;

use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetAttendanceForIdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message' => __('messages.attendance.get_for_id.success'),
            'attendance' => $this->resource instanceof Attendance ? AttendanceResource::make($this->resource) : AttendanceResource::collection($this->resource)
        ];
    }
}
