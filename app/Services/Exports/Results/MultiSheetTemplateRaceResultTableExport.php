<?php

namespace App\Services\Exports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Excel\Export\SuccessRaceResultsExport;
use App\Models\AppointmentRace;
use App\Models\Race;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Exports\Results\TemplateRaceResultsTableExport;

class MultiSheetTemplateRaceResultTableExport implements WithMultipleSheets
{
    private int $race_id;

    public function __construct(int $race_id)
    {
        $this->race_id = $race_id;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];
        $race = Race::with('grades')->find($this->race_id);
        $appr = AppointmentRace::where('race_id', $this->race_id)
            ->with('location', 'command')
            ->get()
            ->toArray();

        foreach ($race->grades as $grade) {
            $sheets[] = new TemplateRaceResultsTableExport($appr, $grade->id, $grade->name);
        }
        return $sheets;
    }
}
