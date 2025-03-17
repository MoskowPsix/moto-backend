<?php

<<<<<<<< HEAD:app/Http/Resources/User/AddCommission/SuccessAddCommissionResource.php
namespace App\Http\Resources\User\AddCommission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessAddCommissionResource extends JsonResource
========
namespace App\Http\Resources\Cup\Create;

use App\Http\Resources\Cup\CupResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessCreateCupResource extends JsonResource
>>>>>>>> generate-pdf-fields:app/Http/Resources/Cup/Create/SuccessCreateCupResource.php
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
<<<<<<<< HEAD:app/Http/Resources/User/AddCommission/SuccessAddCommissionResource.php
            'message' => __('messages.commission.add.success'),
========
            'message' => __('messages.cup.create.success'),
            'cup' => CupResource::make($this->resource)
>>>>>>>> generate-pdf-fields:app/Http/Resources/Cup/Create/SuccessCreateCupResource.php
        ];
    }
}
