<?php

namespace App\Services\Imports\Results;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class TemplateRaceResultsSheetTableImport implements ToCollection
{
    private string $sheetName;

    public function __construct(string $sheetName)
    {
        $this->sheetName = $sheetName;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $sheet = $collection->toArray();
        $data = [];
        foreach ($sheet as $row) {

            if (empty(array_filter($row))) {
                continue;
            }

            $data[] = [
                'Место'             => $row[1],
                'Ст. №'             => $row[2],
                'Сумма лич.очки'    => $row[13],
            ];
        }
        dd("Данные из листа '{$this->sheetName}':", $data);
    }
}
