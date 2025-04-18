<?php

namespace App\Exports;

use App\Enums\DocumentType;
use App\Models\AppointmentRace;
use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentRaceForGradeUserExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    private int $raceId;
    private int $gradeId;
    private string $gradeName;

    public function __construct(int $raceId, int $gradeId, string $gradeName)
    {
        $this->raceId = $raceId;
        $this->gradeId = $gradeId;
        $this->gradeName = $gradeName;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Стартовый Номер',
            'Имя участника',
            'Фамилия участника',
            'Отчество участника',
            'Дата Рождения',
            'Номер Лицензии',
            'Спортивное звание',
            'Населённый пункт (город, область)',
            'Команда (Клуб)',
            'Марка мотоцикла',
        ];
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
        foreach ($appr as $value) {
            $row = [];

            $row['ID'] = $value['id'];
            $row['Стартовый Номер'] = $value['start_number'] ?? '';
            $row['Имя участника'] = $value['name'] ?? '';
            $row['Фамилия участника'] = $value['surname'] ?? '';
            $row['Отчество участника'] = $value['patronymic'] ?? '';
            $row['Дата Рождения'] = isset($value['date_of_birth']) ? Carbon::parse($value['date_of_birth'])->format('d.m.Y') : '';
            $row['Номер Лицензии'] = '';
            $row['Спортивное звание (разряд)'] = $value['rank'] ?? '';
            $row['Населенный пункт (город, область)'] = isset($value['location'])
                ? ('г. ' . ($value['city'] ?? '') . ', ' . ($value['location']['name'] ?? '') . ' ' . ($value['location']['type'] ?? ''))
                : '';
            $row['Команда (Клуб)'] = !empty($value['command_id']) ? $value['command']['name'] ?? 'Лично' : 'Лично';
            $row['Марка мотоцикла'] = $value['moto_stamp'] ?? '';

            foreach ($value['documents'] as $document) {
                if ($document['type'] === DocumentType::Licenses->value) {
                    $row['Номер Лицензии'] = $document['number'] ?? '';
                }
            }
            $rows[] = $row;
        }
        return collect($rows);
    }
    public function title(): string
    {
        return $this->gradeName;
    }
    public function styles(Worksheet  $sheet)
    {
        $sheet->getStyle('A1:X1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:X1')->getFont()->setBold(true);
        $sheet->getStyle('A2:A1000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:X1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
    }
}
