<?php

namespace App\Services\Exports\Results;

use App\Models\AppointmentRace;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateRaceResultsTableExport implements FromCollection, WithStyles, WithTitle, WithHeadings, ShouldAutoSize
{
    private int $raceId;

    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $appr = AppointmentRace::where('race_id', $this->raceId)
            ->with('location', 'documents', 'grade')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        $rows = [];
        foreach ($appr as $value){
            $row = [];

            $row['Место'] = '';
            $row['Ст. №'] = $value['start_number'] ?? '';
            $row['Фамилия'] = $value['surname'] ?? '';
            $row['Имя'] = $value['name'] ?? '';
            $row['Спортивное звание/разряд'] = $value['rank'] ?? '';
            $row['Населённый пункт (регион)'] = isset($value['location'])
                ? ('г. ' . ($value['city'] ?? '') . ', ' . ($value['location']['name'] ?? '') . ' ' . ($value['location']['type'] ?? ''))
                : '';
            $row['Команда (Клуб)'] = !empty($value['command_id']) ? $value['command']['name'] ?? 'Лично' : 'Лично';
            $row['Марка мотоцикла'] = $value['moto_stamp'] ?? '';

            $row['Сумма лич.очки'] = '';

            $rows[] = $row;
        }
        return collect($rows);
    }
    public function title(): string
    {
        return 'Результаты';
    }

    public function headings(): array
    {
        return [
            'Место',
            'Ст. №',
            'Фамилия',
            'Имя',
            'Спортивное звание/разряд',
            'Населённый пункт (регион)',
            'Команда (Клуб)',
            'Марка мотоцикла',
        ];
    }

    /**
     * @throws Exception
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:M1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->getFont()->setItalic(true);

        $sheet->getStyle('I2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('I1', 'I заезд',);
        $sheet->mergeCells('I1:J1');
        $sheet->setCellValue('I2', 'место');
        $sheet->setCellValue('J2', 'личн.очки');

        $sheet->setCellValue('K1', 'II заезд',);
        $sheet->mergeCells('K1:L1');
        $sheet->setCellValue('K2', 'место');
        $sheet->setCellValue('L2', 'личн.очки');
        $sheet->setCellValue('M1', 'Сумма лич.очки');

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:H2');
        $sheet->mergeCells('M1:M2');
    }
}
