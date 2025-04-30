<?php

namespace App\Services\Exports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Excel\Export\SuccessRaceResultsExport;
use App\Models\Race;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Services\Exports\Results\TemplateRaceResultsTableExport;

class MultiSheetTemplateRaceResultTableExport implements WithMultipleSheets
{
    private int $race_id;
    private array $sheets = [];

    public function __construct(int $race_id)
    {
        $this->race_id = $race_id;

        $race = Race::find($this->race_id);
        if(!$race){
            return NotFoundResource::make([]);
        }
        $user = auth()->user();
        if(!$user || $race->commissions()->where('user_id', $user->id)->exists()){
            return NotUserPermissionResource::make([]);
        }
        foreach ($race->grades as $grade) {
           $this->sheets[] = new TemplateRaceResultsTableExport($this->race_id, $grade->id, $grade->name);
        }
        return SuccessRaceResultsExport::make([]);
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        return $this->sheets;
//        $sheets = [];
//        $race = Race::with('grades')->find($this->race_id);
//
//        foreach ($race->grades as $grade) {
//            $sheets[] = new TemplateRaceResultsTableExport($this->race_id, $grade->id, $grade->name);
//        }
//        return $sheets;
    }
}
