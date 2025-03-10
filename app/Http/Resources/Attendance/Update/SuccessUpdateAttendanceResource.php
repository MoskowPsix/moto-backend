<?php

namespace App\Http\Resources\Attendance\Update;

use App\Http\Resources\Attendance\AttendanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.attendance.update.success'),
            'attendance' => AttendanceResource::make($this->resource),
        ];
    }
}
