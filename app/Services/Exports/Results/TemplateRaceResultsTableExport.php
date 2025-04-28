<?php

namespace App\Services\Exports\Results;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
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
    private int $gradeId;
    private string $gradeName;
    private int $userId;

    public function __construct(int $raceId, int $gradeId, string $gradeName, int $userId)
    {
        $this->raceId = $raceId;
        $this->gradeId = $gradeId;
        $this->gradeName = $gradeName;
        $this->userId = $userId;

        $this->checkPermission();
    }

    private function checkPermission()
    {
        $race = Race::find($this->raceId);
        if (!$race) {
            return NotFoundResource::make([]);
        }
        $appointment = AppointmentRace::where('race_id', $this->raceId);
        if (!$appointment->exists()) {
            return NotFoundResource::make([]);
        }
        if(!$race->commissions()->where('user_id', $this->userId)->exists()) {
            return NotUserPermissionResource::make([]);
        }
        return $appointment;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $appr = AppointmentRace::where('race_id', $this->raceId)
            ->where('grade_id', $this->gradeId)
            ->with('location', 'documents', 'grade')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        $rows = [];
        foreach ($appr as $value){
            $row = [];

            $row['ID'] = $value['user_id'] ?? '';
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
        return $this->gradeName;
    }

    public function headings(): array
    {
        return [
            'ID',
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
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:N1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFont()->setItalic(true);

        $sheet->getStyle('I2:L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I2:L2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $sheet->setCellValue('J1', 'I заезд');
        $sheet->mergeCells('J1:K1');
        $sheet->setCellValue('J2', 'место');
        $sheet->setCellValue('K2', 'личн.очки');

        $sheet->setCellValue('L1', 'II заезд');
        $sheet->mergeCells('L1:M1');
        $sheet->setCellValue('L2', 'место');
        $sheet->setCellValue('M2', 'личн.очки');
        $sheet->setCellValue('N1', 'Сумма лич.очки');

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

        $sheet->getStyle('B1:N1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        $sheet->getColumnDimension('A')->setVisible(false);
        $sheet->getStyle('A1:A1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
        $sheet->getProtection()->setSheet(true);
        $sheet->getProtection()->setSort(true);
        $sheet->getProtection()->setFormatCells(true);
    }
}
