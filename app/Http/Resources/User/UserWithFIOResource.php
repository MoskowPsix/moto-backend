<?php

namespace App\Http\Resources\User;

use App\Http\Resources\PersonalInfo\PersonalInfoResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Transaction\ShortTransactionResource;
use App\Http\Resources\Transaction\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property object $personalInfo
 * @property object $role
 * @property string $avatar
 * @property string $name
 * @property int $id
 */
class UserWithFIOResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        dd($this->resource->personalInfo);
        if(empty($this->personalInfo)) {
            $personal = [];
        } else {
            $personal = [
                'name'          => $this->personalInfo->name,
                'surname'       => $this->personalInfo->surname,
                'patronymic'    => $this->personalInfo->patronymic,
                'date_of_birth' => $this->personalInfo->date_of_birth,
                'city'          => $this->personalInfo->city,
                'region'        => $this->personalInfo->region,
                'rank'          => $this->personalInfo->rank,
                'start_number'  => $this->personalInfo->start_number,
                'command'       => $this->personalInfo->command,
            ];
        }
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'avatar'                => $this->avatar,
            'personal'              => $personal,
            'roles'                 => RoleResource::collection($this->whenLoaded('roles')),
            'transactions'          => ShortTransactionResource::collection($this->whenLoaded('transactions')),
        ];
    }
}
