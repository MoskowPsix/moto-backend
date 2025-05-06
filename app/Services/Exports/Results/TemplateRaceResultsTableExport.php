<?php

namespace App\Services\Exports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateRaceResultsTableExport implements FromCollection, WithStyles, WithTitle, WithHeadings, ShouldAutoSize
{
    private array $race;
    private int $gradeId;
    private string $gradeName;
    public function __construct(array $race, int $gradeId, string $gradeName)
    {
        $this->race = $race;
        $this->gradeId = $gradeId;
        $this->gradeName = $gradeName;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        foreach ($this->race as $value){
            $row = [];

            $row['Место'] = '';
            $row['UID'] = $value['user_id'] ?? '';
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
        return $this->gradeName;
    }

    public function headings(): array
    {
        return [
            'Место',
            'UID',
            'Ст. №',
            'Фамилия',
            'Имя',
            'Спортивное звание/разряд',
            'Населённый пункт (регион)',
            'Команда (Клуб)',
            'Марка мото',
        ];
    }

    /**
     * @throws Exception
     */
    public function styles(Worksheet $sheet): void
    {
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:N1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFont()->setItalic(true);

        $sheet->getStyle('J2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J2:L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('J1', 'I заезд');
        $sheet->mergeCells('J1:K1');
        $sheet->setCellValue('J2', 'место');
        $sheet->setCellValue('K2', 'личн. очки');

        $sheet->setCellValue('L1', 'II заезд');
        $sheet->mergeCells('L1:M1');
        $sheet->setCellValue('L2', 'место');
        $sheet->setCellValue('M2', 'личн. очки');
        $sheet->setCellValue('N1', 'Сумма лич. очки');

        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:H2');
        $sheet->mergeCells('I1:I2');
        $sheet->mergeCells('N1:N2');

        $sheet->getStyle('A1:A'. count($this->race) + 1)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
        $sheet->getStyle('C1:N'. count($this->race) + 1)->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        $sheet->getColumnDimension('B')->setVisible(false);
        $sheet->getStyle('B1:B'. count($this->race))->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setSort(true);
        $sheet->getProtection()->setFormatCells(true);
    }
}
