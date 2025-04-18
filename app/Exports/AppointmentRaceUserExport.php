<?php

namespace App\Exports;

use App\Enums\DocumentType;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AppointmentRaceUserExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    private int $raceId;
//    private int $userId;
    public function __construct(int $raceId)
    {
        $this->raceId = $raceId;
//        $this->userId = $userId;

        $this->checkPermission();
    }
    private function checkPermission()
    {
        $race = Race::find($this->raceId);
        if(!$race){
            throw new ModelNotFoundException('Гонка не найдена.');
        }

        $appr = AppointmentRace::where('race_id', $this->raceId);

        if (!$appr->exists()) {
            throw new ModelNotFoundException('Нет данных для экспорта.');
        }

//        if(!$race->commissions()->where('users.id', $this->userId)->exists())
//        {
//            throw new \Exception('Нет прав доступа.');
//        }
        return $appr;
    }
    public function headings(): array
    {
        return [
            'Отметка времени',
            'Фамилия участника',
            'Имя участника',
            'Отчество участника',
            'Класс',
            'Двигатель',
            'Стартовый Номер',
            'Номер Лицензии',
            'Спортивное звание (разряд)',
            'Дата Рождения',
            'Населенный пункт (город, область)',
            'Команда (Клуб)',
            'Марка мотоцикла',
            'Страховой полис: Срок действия',
            'Серия и номер паспорта/ свидетельства о рождении',
            'Пенсионное страховое свидетельство (СНИЛС)',
            'Номер телефона',
            'Страховой полис: Серия и номер',
            'Страховой полис: Кем выдан',
            'Тренер: ФИО',
            'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)',
            'Скан или фотография Страховки',
            'Скан или фотография Лицензии',
            'Скан или фотография нотариального согласия от обоих родителей',
        ];
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
        foreach ($appr as $value) {
            $row = [];

            // Заполняем массив с проверкой на null или пустоту
            $row['Отметка времени'] = Carbon::parse($value['created_at'])->format('d.m.Y h:m:s');
            $row['Фамилия участника'] = $value['surname'] ?? '';
            $row['Имя участника'] = $value['name'] ?? '';
            $row['Отчество участника'] = $value['patronymic'] ?? '';
            $row['Класс'] = $value['grade']['name'] ?? '';
            $row['Двигатель'] = $value['engine'] ?? '';
            $row['Стартовый Номер'] = $value['start_number'] ?? '';
            $row['Номер Лицензии'] = ''; // Будет заполнено ниже через документы
            $row['Спортивное звание (разряд)'] = $value['rank'] ?? '';
            $row['Дата Рождения'] = isset($value['date_of_birth']) ? Carbon::parse($value['date_of_birth'])->format('d.m.Y') : '';
            $row['Населенный пункт (город, область)'] = isset($value['location'])
                ? ('г. ' . ($value['city'] ?? '') . ', ' . ($value['location']['name'] ?? '') . ' ' . ($value['location']['type'] ?? ''))
                : '';
            $row['Команда (Клуб)'] = !empty($value['command_id']) ? $value['command']['name'] ?? 'Лично' : 'Лично';
            $row['Марка мотоцикла'] = $value['moto_stamp'] ?? '';
            $row['Страховой полис: Срок действия'] = '';
            $row['Серия и номер паспорта/ свидетельства о рождении'] = $value['number_and_seria'] ?? '';
            $row['Пенсионное страховое свидетельство (СНИЛС)'] = $value['snils'] ?? '';
            $row['Номер телефона'] = $value['phone_number'] ?? '';
            $row['Страховой полис: Серия и номер'] = '';
            $row['Страховой полис: Кем выдан'] = '';
            $row['Тренер: ФИО'] = $value['coach'] ?? '';
            $row['ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'] = $value['inn'] ?? '';
            $row['Скан или фотография Страховки'] = '';
            $row['Скан или фотография Лицензии'] = '';
            $row['Скан или фотография нотариального согласия от обоих родителей'] = '';

            foreach ($value['documents'] as $document) {
                switch ($document['type']) {
                    case DocumentType::Polis->value:
                        $row['Скан или фотография Страховки'] = $this->appendValueOrEmpty($row['Скан или фотография Страховки'], $document['url_view']);
                        $row['Страховой полис: Серия и номер'] = $document['number'] ?? '';
                        $row['Страховой полис: Кем выдан'] = $document['issued_whom'] ?? '';
                        $row['Страховой полис: Срок действия'] = isset($document['it_works_date']) ? Carbon::parse($document['it_works_date'])->format('d.m.Y') : '';
                        break;
                    case DocumentType::Licenses->value:
                        $row['Скан или фотография Лицензии'] = $this->appendValueOrEmpty($row['Скан или фотография Лицензии'], $document['url_view']);
                        $row['Номер Лицензии'] = $document['number'] ?? '';
                        break;
                    case DocumentType::Notarius->value:
                        $row['Скан или фотография нотариального согласия от обоих родителей'] = $this->appendValueOrEmpty($row['Скан или фотография нотариального согласия от обоих родителей'], $document['url_view']);
                        break;
                }
            }
            $rows[] = $row;
        }
        return collect($rows);
    }

    public function title(): string
    {
        return 'Список';
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:X1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:X1')->getFont()->setBold(true);
        $sheet->getStyle('A2:A1000')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:X1000')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);
    }
    private function appendValueOrEmpty(string $currentValue, string $newValue): string
    {
        return !empty($currentValue) ? $newValue . ', ' . $currentValue : $newValue;
    }
}
