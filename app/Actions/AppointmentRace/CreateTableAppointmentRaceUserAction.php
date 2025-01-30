<?php

namespace App\Actions\AppointmentRace;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Services\GoogleSheetServiceContract;
use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\AppointmentRace;
use App\Models\Race;
use App\Models\User;
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

    public function __invoke(int $id): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource
    {
        $race = Race::find($id);
        if (auth()->user()->id !== $race->user_id) {
            return NotUserPermissionResource::make();
        }

        $appr = AppointmentRace::where('race_id', $id);
        $fields = [
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
        $rows = $this->formTable($appr->get());
        $url = $this->sheetService->create(uniqid(), $fields, $rows);
        auth()->user()->notify(new CreateTableAppointmentRaceUserNotify($url, $race));
        return SuccessCreateTableAppointmentRaceResource::make($url);
    }

    private function formTable(Collection $appr): array
    {
        foreach ($appr->toArray() as $key => $value) {
            $info = json_decode($value['data'], true);
            $rows[] = [
                'Отметка времени'                                                   => Carbon::now()->format('d.m.Y h:m:s'),
                'Фамилия участника'                                                 => $info['surname'] ?? '',
                'Имя участника'                                                     => $info['name'] ?? '',
                'Отчество участника'                                                => $info['patronymic'] ?? '',
                'Класс'                                                             => $info['group'] ?? '',
                'Двигатель'                                                         => $info['engine'] ?? '',
                'Стартовый Номер'                                                   => $info['startNumber'] ?? '',
                'Номер Лицензии'                                                    => $info['licensesNumber'] ?? '',
                'Спортивное звание (разряд)'                                        => $info['rank'] ?? '',
                'Дата Рождения'                                                     => isset($info['dateOfBirth']) ? Carbon::parse($info['dateOfBirth'])->format('d.m.Y') : '',
                'Населенный пункт (город, область)'                                 => $info['city'] ?? '',
                'Команда (Клуб)'                                                    => $info['community'] ?? '',
                'Марка мотоцикла'                                                   => $info['motoStamp'] ?? '',
                'Страховой полис: Срок действия'                                    => isset($info['itWorksDate']) ? Carbon::parse($info['itWorksDate'])->format('d.m.Y') : '',
                'Серия и номер паспорта/ свидетельства о рождении'                  => $info['numberAndSeria'] ?? '',
                'Номер телефона'                                                    => $info['phoneNumber'] ?? '',
                'Страховой полис: Серия и номер'                                    => $info['polisNumber'] ?? '',
                'Страховой полис: Кем выдан'                                        => $info['issuedWhom'] ?? '',
                'Тренер: ФИО'                                                       => $info['coach'] ?? '',
                'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'   => $info['inn'] ?? '',
                ''                                                                  => '',
                'Скан или фотография Страховки'                                     => $info['polisFileLink'] ?? '',
                'Скан или фотография Лицензии'                                      => $info['licensesFileLink'] ?? '',
                'Скан или фотография нотариального согласия от обоих родителей'     => '',
            ];
        }
        return $rows;
    }
}
