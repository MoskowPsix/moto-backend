<?php

namespace App\Http\Resources\Excel\Export;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessRaceResultsExport extends JsonResource
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
            'message' => __('messages.export.results.success'),
        ];
    }
}
