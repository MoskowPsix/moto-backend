<?php

namespace App\Services\Imports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateRaceResultsTableImport implements ToCollection, WithHeadings
{
    private int $raceId;
//    private int $userId;

    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
//        $this->userId = $userId;

        $this->checkPermission();
    }

    private function checkPermission()
    {
        $race = Race::find($this->raceId);
        if (!$race) {
            return NotFoundResource::make([]);
        }
//        if(!$race->commissions()->where('users.id', $this->userId)->exists()){
//            return NotUserPermissionResource::make([]);
//        }
        return 0;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $id = $row['ID'] ?? null;

            if(!$id){
                continue;
            }
            $appointment = AppointmentRace::where('user_id', $id)->where('race_id', $this->raceId)->first();

            if (!$appointment) {
                continue;
            }
            $appointment->update([
                'start_number'      => $row['Ст. №'] ?? $appointment->start_number,
                'surname'           => $row['Фамилия'] ?? $appointment->surname,
                'name'              => $row['Имя'] ?? $appointment->name,
                'rank'              => $row['Спортивное звание/разряд'] ?? $appointment->rank,
                'city'              => $row['Населённый пункт (регион)'] ?? $appointment->city,
                'command_id'        => $row['Команда (Клуб)'] ?? $appointment->command_id,
                'moto_stamp'        => $row['Марка мотоцикла'] ?? $appointment->moto_stamp,
            ]);
        }
    }
    public function headings(): array
    {
        return [
            'Ст. №',
            'Фамилия',
            'Имя',
            'Спортивное звание/разряд',
            'Населённый пункт (регион)',
            'Команда (Клуб)',
            'Марка мотоцикла',
        ];
    }
}
