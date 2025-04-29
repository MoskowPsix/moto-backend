<?php

namespace App\Services\Imports\Results;

use App\Http\Resources\Errors\EmptyListResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Excel\Import\SuccessRaceResultsImport;
use App\Models\AppointmentRace;
use App\Models\Command;
use App\Models\Grade;
use App\Models\Race;
use App\Models\RaceResult;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TemplateRaceResultsSheetTableImport implements ToCollection
{
    private string $sheetName;
    private int $race_id;

    public function __construct(string $sheetName, int $race_id)
    {
        $this->sheetName = $sheetName;
        $this->race_id = $race_id;
    }

    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows): SuccessRaceResultsImport | NotFoundResource | EmptyListResource
    {
        if($rows->isEmpty()) {
            return EmptyListResource::make([]);
        }

        // Получение заголовков
        $headers = $rows->first();

        //Проверяем наличие нужных колонок
        $requiredHeaders = ['Место', 'UID', 'Ст. №', 'Сумма лич. очки', 'Команда (Клуб)'];
        $missingHeaders = array_diff($requiredHeaders, $headers->toArray());

        if(!empty($missingHeaders)) {
            return EmptyListResource::make([]);
        }

        // находим id класса
        $grade = Grade::where('name', $this->sheetName)->first();
        if (!$grade) {
            return NotFoundResource::make([]);
        }
        $gradeId = $grade->id;

        //находим id кубка
        $race = Race::with('cups')->find($this->race_id);
        $cupId = $race?->cups->pluck('id')->toArray() ?? [];

        $rows->slice(1)->each(function ($row) use ($headers, $gradeId, $cupId) {
            $id = $row->get($headers->search('UID'));
            $user = User::where('id', $id)->first();

            if (!$user) {
                return NotFoundResource::make([]);
            }

            $race = Race::find($this->race_id);
            if($race->commissions()->where('user_id', $user->id)->exists()) {
                return NotUserPermissionResource::make([]);
            }

            $commandName = $row->get($headers->search('Команда (Клуб)'));
            $command = Command::where('name', $commandName)->first();
            $commandId = $command?->id ?? null;

            RaceResult::create([
                'user_id'       => $user->id,
                'race_id'       => $this->race_id,
                'cup_id'        => $cupId[0] ?? null,
                'command_id'    => $commandId,
                'grade_id'      => $gradeId,
                'scores'        => $row->get($headers->search('Сумма лич. очки')),
                'place'         => $row->get($headers->search('Место')),
            ]);
        });
        return SuccessRaceResultsImport::make([]);
    }
}
