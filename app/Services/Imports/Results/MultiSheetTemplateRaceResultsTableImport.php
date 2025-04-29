<?php

namespace App\Services\Imports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetTemplateRaceResultsTableImport implements WithMultipleSheets
{
    private int $race_id;
    private array $sheet;
    public function __construct(int $race_id)
    {
        $this->race_id = $race_id;
    }

    public function sheets(): array
    {
        Race::where('id', $this->race_id)->first()->grades()->each(function ($grade) {
            $this->sheet[$grade->name] = new TemplateRaceResultsSheetTableImport($grade->name, $this->race_id);
        });

        return $this->sheet;
    }
}
