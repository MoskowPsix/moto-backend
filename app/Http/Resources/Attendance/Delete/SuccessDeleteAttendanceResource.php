<?php

namespace App\Http\Resources\Attendance\Delete;

use App\Http\Resources\Attendance\AttendanceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessDeleteAttendanceResource extends JsonResource
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
            'message' => __('messages.attendance.delete.success'),
            'attendance' => AttendanceResource::make($this->resource),
        ];
    }
}
