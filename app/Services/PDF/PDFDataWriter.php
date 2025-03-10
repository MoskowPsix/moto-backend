<?php

namespace App\Services\PDF;

use App\Models\AppointmentRace;
use Carbon\Carbon;
use setasign\Fpdi\Tcpdf\Fpdi;

class PDFDataWriter
{
    protected Fpdi $pdf;

    public function __construct(Fpdi $pdf)
    {
        $this->pdf = $pdf;
    }
    //Запись данных
    public function writePDF(AppointmentRace $fields): void
    {
        $fieldCoordinate = [
            'name' => [
                'x' => 57.5,
                'y' => 83,
                'width' => 145.5,
                'height' => 6,
                'align' => 'L',
                'value' => $fields->name
            ],
            'surname' => [
                'x' => 57.5,
                'y' => 77,
                'width' => 145.5,
                'height' => 6,
                'align' => 'L',
                'value' => $fields->surname],
            'patronymic' => [
                'x' => 57.5,
                'y' => 89,
                'width' => 145.5,
                'height' => 6,
                'align' => 'L',
                'value' => $fields->patronymic],
            'date_of_birth' => [
                'x' => 57.5,
                'y' => 117,
                'width' => 69,
                'height' => 4,
                'align' => 'L',
                'value' => $fields->date_of_birth],
            'city' => [
                'x' => 57.5,
                'y' => 123,
                'width' => 145.5,
                'height' => 6,
                'align' => 'L',
            ],
            'inn' => [
                'x' => 57,
                'y' => 188.5,
                'width' => 30.5,
                'height' => 4.7,
                'align' => 'L',
                'value' => $fields->inn],
            'snils' => [
                'x' => 173,
                'y' => 188.5,
                'width' => 30,
                'height' => 4.7,
                'align' => 'L',
                'value' => $fields->snils],
            'phone_number' => [
                'x' => 38,
                'y' => 205,
                'width' => 88,
                'height' => 4.7,
                'align' => 'L',
                'value' => $fields->phone_number],
            'start_number' => [
                'x' => 173,
                'y' => 45,
                'width' => 30,
                'height' => 12,
                'align' => 'C',
                'value' => $fields->start_number],
            'group' => [
                'x' => 12,
                'y' => 45,
                'width' => 45,
                'height' => 12,
                'align' => 'C',
                'value' => $fields->group],
            'rank_number' => [
                'x' => 107,
                'y' => 101,
                'width' => 96,
                'height' => 5,
                'align' => 'C',
                'value' => $fields->rank_number],
            'rank' => [
                'x' => 107,
                'y' => 110,
                'width' => 96,
                'height' => 5,
                'align' => 'C',
                'value' => $fields->rank],
            'community' => [
                'x' => 38,
                'y' => 131,
                'width' => 80,
                'height' => 5,
                'align' => 'L',
            ],
            'class' => [
                'x' => 12,
                'y' => 45,
                'width' => 45,
                'height' => 12,
                'align' => 'C',
            ],
            'coach' => [
                'x' => 107,
                'y' => 153.5,
                'width' => 96,
                'height' => 4,
                'align' => 'L',
                'value' => $fields->coach],
            'moto_stamp' => [
                'x' => 88,
                'y' => 138,
                'width' => 62,
                'height' => 5,
                'align' => 'C',
                'value' => $fields->moto_stamp],
            'engine' => [
                'x' => 69,
                'y' => 45,
                'width' => 38,
                'height' => 12,
                'align' => 'C',
                'value' => $fields->engine],
            'polis_number' => [
                'x' => 88,
                'y' => 164,
                'width' => 38,
                'height' => 5,
                'align' => 'L',
                'value' => $fields->polis_number],
            'number_and_seria' => [
                'x' => 160.2,
                'y' => 179.5,
                'width' => 42.5,
                'height' => 5,
                'align' => 'L',
                'value' => $fields->number_and_seria],

            'RaceName' => [
                'x' => 12,
                'y' => 65,
                'width' => 191,
                'height' => 5,
                'align' => 'C',
            ],
            'RaceAdr' => [
                'x' => 12,
                'y' => 70,
                'width' => 138,
                'height' => 5,
                'align' => 'C',
            ],
            'date_start' => [
                'x' => 150.5,
                'y' => 70,
                'width' => 52,
                'height' => 5,
                'align' => 'C',
            ],
        ];

        foreach ($fieldCoordinate as $fieldName => $coordinates) {
            $value = null;

            if ($fieldName === 'city' && $fields->location) {
                $value = $fields->location->name;
            } else if ($fieldName === 'RaceName' && $fields->race) {
                $value = $fields->race->name;
            } else if ($fieldName === 'RaceAdr' && $fields->race) {
                $value = 'г. ' . $fields->city . ', ' . $fields->location()->first()->name . ' ' . $fields->location()->first()->type;
            } else if ($fieldName === 'date_start' && $fields->race) {
                $value = Carbon::parse($fields->race->date_start)->format('d.m.Y');
            }
            else if($fieldName === 'class' && $fields->grade){
                $value = $fields->grade->name;
            }
            else if($fieldName === 'community' && $fields->command){
                $value = $fields->command->first()->name;
            }
            else {
                $value = $fields->$fieldName ?? null;
            }

            if ($value) {
                $this->pdf->setXY($coordinates['x'], $coordinates['y']);
                $this->pdf->MultiCell(
                    $coordinates['width'],
                    $coordinates['height'],
                    $value,
                    0,
                    $coordinates['align']
                );
            }
        }
    }
}
