<?php

namespace App\Contracts\Actions\Controllers\Export;

use App\Exports\AppointmentRaceForGradeUserExport;
use App\Exports\AppointmentRaceUserExport;
use App\Models\Grade;
use App\Models\Race;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetAppointmentRaceExport implements WithMultipleSheets
{
    private $raceId;
//    private $userId;
    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AppointmentRaceUserExport($this->raceId);

        $race = Race::with('grades')->find($this->raceId);
        foreach ($race as $grade) {
            $sheets[] = new AppointmentRaceForGradeUserExport($this->raceId, $grade->id, $grade->name);
        }
        return $sheets;
    }
}
