<?php

namespace App\Contracts\Actions\Controllers\Export;

use App\Exports\AppointmentRaceUserExport;
use App\Exports\TestExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetAppointmentRaceExport implements WithMultipleSheets
{
    private $raceId;
    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        return [
            new AppointmentRaceUserExport($this->raceId),
            new TestExport(),
        ];
    }
}
