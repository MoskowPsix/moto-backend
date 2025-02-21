<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Services\GoogleSheetServiceContract;
use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use App\Notifications\CreateTableAppointmentRaceUserNotify;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;

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
        $rows = $this->formTable($appr->oldest('created_at')->get());
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

    private function formTable(Collection $appr): array
    {
        foreach ($appr->toArray() as $key => $value) {
            $info = json_decode($value['data'], true);
            $rows[] = [
                'Отметка времени'                                                   => Carbon::parse($value['created_at'])->setTimezone('Asia/Yekaterinburg')->format('d.m.Y H:m:s'),
                'Фамилия участника'                                                 => $info['surname'] ?? '',
                'Имя участника'                                                     => $info['name'] ?? '',
                'Отчество участника'                                                => $info['patronymic'] ?? '',
                'Класс'                                                             => $info['group'] ?? '',
                'Двигатель'                                                         => $info['engine'] ?? '',
                'Стартовый Номер'                                                   => $info['startNumber'] ?? '',
                'Номер Лицензии'                                                    => $info['licensesNumber'] ?? '',
                'Спортивное звание (разряд)'                                        => $info['rank'] ?? '',
                'Дата Рождения'                                                     => isset($info['dateOfBirth']) ? Carbon::parse($info['dateOfBirth'])->format('d.m.Y') : '',
                'Населенный пункт (город, область)'                                 => 'г. ' . ($info['city'] ?? '') . ', ' . ($info['region'] ?? ''),
                'Команда (Клуб)'                                                    => $info['community'] ?? '',
                'Марка мотоцикла'                                                   => $info['motoStamp'] ?? '',
                'Страховой полис: Срок действия'                                    => isset($info['itWorksDate']) ? Carbon::parse($info['itWorksDate'])->format('d.m.Y') : '',
                'Серия и номер паспорта/ свидетельства о рождении'                  => $info['numberAndSeria'] ?? '',
                'Пенсионное страховое свидетельство (СНИЛС)'                        => $info['snils'] ?? '',
                'Номер телефона'                                                    => $info['phoneNumber'] ?? '',
                'Страховой полис: Серия и номер'                                    => $info['polisNumber'] ?? '',
                'Страховой полис: Кем выдан'                                        => $info['issuedWhom'] ?? '',
                'Тренер: ФИО'                                                       => $info['coach'] ?? '',
                'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'   => $info['inn'] ?? '',
                ''                                                                  => '',
                'Скан или фотография Страховки'                                     => $info['polisFileLink'] ?? '',
                'Скан или фотография Лицензии'                                      => $info['licensesFileLink'] ?? '',
                'Скан или фотография нотариального согласия от обоих родителей'     => $info['notariusFileLink'] ?? '',
            ];
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
