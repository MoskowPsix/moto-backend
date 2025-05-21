<?php

namespace App\Services\Exports;

use App\Models\Race;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetAppointmentRaceExport implements WithMultipleSheets
{
    private $raceId;
    private $userId;
    public function __construct(int $raceId, int $userId)
    {
        $this->raceId = $raceId;
        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new AppointmentRaceUserExport($this->raceId, $this->userId);

        $race = Race::with('grades')->find($this->raceId);
        foreach ($race->grades as $grade) {
            $sheets[] = new AppointmentRaceForGradeUserExport($this->raceId, $grade->id, $grade->name);
        }
        return $sheets;
    }
}
