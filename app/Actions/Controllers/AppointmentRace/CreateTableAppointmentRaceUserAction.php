<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Services\GoogleSheetServiceContract;
use App\Enums\DocumentType;
use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Command;
use App\Models\Race;
use App\Notifications\CreateTableAppointmentRaceUserNotify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class CreateTableAppointmentRaceUserAction implements  CreateTableAppointmentRaceUserActionContract
{
    private GoogleSheetServiceContract $sheetService;
    public function __construct(GoogleSheetServiceContract $service)
    {
        $this->sheetService = $service;
    }

    public function __invoke(int $id): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource | NotFoundResource
    {
        // Достаём гонку
        $race = Race::find($id);

        $appr = AppointmentRace::where('race_id', $id);
        if (!$appr->exists()) {
            return NotFoundResource::make([]);
        }
        // Получаем поля будующей таблицы
        $fields = $this->getFields();
        // Формируем данные для таблицы участников
        $rows = $this->formTable($appr->with('location', 'documents', 'grade')->orderBy('created_at', 'asc')->orderBy('created_at', 'asc')->get()->toArray());
        // Обновляем или создаём таблицу в Google Sheets
        if ($race->sheet()->exists()){
            // Получаем id таблицы в системе google
            $id = $race->sheet()->first()->spread_sheet_id;
            // Обновляем таблицу в системе google
            $url = $this->sheetService->update($id, $race, $fields, $rows);

        } else {
            // Создаём таблицу в системе google
            $url = $this->sheetService->create(uniqid(), $race, $fields, $rows,);
            // Сохраняем ссылку и id на таблицу google в бд
            $race->sheet()->create([
                'spread_sheet_id'   => $url->sheetID,
                'url'               => $url->url,
            ]);
        }
        // Отправляем уведомление о создании таблицы участников
        auth()->user()->notify(new CreateTableAppointmentRaceUserNotify($url->url, $race));
        return SuccessCreateTableAppointmentRaceResource::make($url->url);
    }

    private function formTable(array $appr): array
    {
        $rows = [];
        foreach ($appr as $value) {
            $row = [
                'Отметка времени'                                                   => Carbon::parse($value['created_at'])->format('d.m.Y h:m:s'),
                'Фамилия участника'                                                 => $value['surname'] ?? '',
                'Имя участника'                                                     => $value['name'] ?? '',
                'Отчество участника'                                                => $value['patronymic'] ?? '',
                'Класс'                                                             => $value['grade']['name'] ?? '',
                'Двигатель'                                                         => $value['engine'] ?? '',
                'Стартовый Номер'                                                   => $value['start_number'] ?? '',
                'Спортивное звание (разряд)'                                        => $value['rank'] ?? '',
                'Дата Рождения'                                                     => isset($value['date_of_birth']) ? Carbon::parse($value['date_of_birth'])->format('d.m.Y') : '',
                'Населенный пункт (город, область)'                                 => 'г. ' . ($value['city'] ?? '') . ', ' . ($value['location']['name'] . ' ' . $value['location']['type'] ?? ''),
                'Команда (Клуб)'                                                    => !empty($value['command_id']) ? Command::find($value['command_id'])->name : 'Лично',
                'Марка мотоцикла'                                                   => $value['moto_stamp'] ?? '',
                'Серия и номер паспорта/ свидетельства о рождении'                  => $value['number_and_seria'] ?? '',
                'Пенсионное страховое свидетельство (СНИЛС)'                        => $value['snils'] ?? '',
                'Номер телефона'                                                    => $value['phone_number'] ?? '',
                'Тренер: ФИО'                                                       => $value['coach'] ?? '',
                'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'   => $value['inn'] ?? '',
                ''                                                                  => '',
                'Скан или фотография Страховки'                                     => '',
                'Страховой полис: Серия и номер'                                    => '',
                'Страховой полис: Кем выдан'                                        => '',
                'Страховой полис: Срок действия'                                    => '',
                'Скан или фотография Лицензии'                                      => '',
                'Номер Лицензии'                                                    => '',
                'Скан или фотография нотариального согласия от обоих родителей'     => '',
            ];

            foreach ($value['documents'] as $document) {
                switch ($document['type']) {
                    case DocumentType::Polis->value:
                        $row['Скан или фотография Страховки'] = $document['url_view'] . ' , ' . $row['Скан или фотография Страховки'];
                        $row['Страховой полис: Серия и номер'] = $document['number'];
                        $row['Страховой полис: Кем выдан'] = $document['issued_whom'];
                        $row['Страховой полис: Срок действия'] = $document['it_works_date'];
                        break;
                    case DocumentType::Licenses->value:
                        $row['Скан или фотография Лицензии'] = !empty($row['Скан или фотография Лицензии']) ? $document['url_view'] . ' , ' . $row['Скан или фотография Лицензии'] : $document['url_view'];
                        $row['Номер Лицензии'] = $document['number'];
                        break;
                    case DocumentType::Notarius->value:
                        $row['Скан или фотография нотариального согласия от обоих родителей'] = $document['url_view'] . ' , ' . $row['Скан или фотография нотариального согласия от обоих родителей'];
                        break;
                }
            }
            $rows[] = $row;
        }
        return $rows;
    }
    private function getFields(): array
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
            '',
            'Скан или фотография Страховки',
            'Скан или фотография Лицензии',
            'Скан или фотография нотариального согласия от обоих родителей',
        ];
    }
}
