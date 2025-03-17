<?php

<<<<<<<< HEAD:app/Http/Resources/Status/StatusResource.php
namespace App\Http\Resources\Status;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $name
 */
class StatusResource extends JsonResource
========
namespace App\Http\Resources\Cup\Update;

use App\Http\Resources\Cup\CupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessUpdateCupResource extends JsonResource
>>>>>>>> generate-pdf-fields:app/Http/Resources/Cup/Update/SuccessUpdateCupResource.php
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
<<<<<<<< HEAD:app/Http/Resources/Status/StatusResource.php
            'name' => $this->name,
========
            'status' => 'success',
            'message' => __('messages.cup.update.success'),
            'cup' => CupResource::make($this->resource)
>>>>>>>> generate-pdf-fields:app/Http/Resources/Cup/Update/SuccessUpdateCupResource.php
        ];
    }
}
