<?php

namespace App\Services\Exports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Excel\Export\SuccessRaceResultsExport;
use App\Models\AppointmentRace;
use App\Models\Race;
use App\Services\Exports\Results\TemplateRaceResultsTableExport;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Normalizer;

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
        $race = Race::with('grades')->find($this->race_id);
        $appr = AppointmentRace::where('race_id', $this->race_id)
            ->with('location', 'command')
            ->get()
            ->groupBy('grade.name')
            ->sortKeys()
            ->toArray();

        foreach ($race->grades as $grade) {
            !empty($appr[$grade->name]) ? $sheets[] = new TemplateRaceResultsTableExport($appr[$grade->name], "($grade->id) " . $grade->name, $grade->id) : null;
        }
        return $sheets;
    }
    // http://localhost:8000/api/races/27/results/export
}
