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
        Race::find($this->race_id)->grades()->each(function ($grade) {
//            dump($grade->name);
//            dump(Race::find($this->race_id)->appointments()->where('grade_id', $grade->id)->exists());
            if (Race::find($this->race_id)->appointments()->where('grade_id', $grade->id)->exists()) {
                $name = trim(substr("($grade->id) " . $grade->name, 0, 47));
                $this->sheet[$name] = new TemplateRaceResultsSheetTableImport($name, $this->race_id);
            }
        });
        return $this->sheet;
    }
}
