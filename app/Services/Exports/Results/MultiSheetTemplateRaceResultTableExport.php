<?php

namespace App\Services\Exports\Results;

use App\Models\Race;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Exports\Results\TemplateRaceResultsTableExport;

class MultiSheetTemplateRaceResultTableExport implements WithMultipleSheets
{
    private int $raceId;
//    private int $userId;
    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
//        $this->userId = $userId;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];
        $race = Race::with('grades')->find($this->raceId);

        foreach ($race->grades as $grade) {
            $sheets[] = new TemplateRaceResultsTableExport($this->raceId, $grade->id, $grade->name);
        }
        return $sheets;
    }
}
