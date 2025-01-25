<?php

namespace App\Actions\AppointmentRace;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Models\Race;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class CreateTableAppointmentRaceUserAction implements  CreateTableAppointmentRaceUserActionContract
{

    public function __invoke(int $id)
    {
        $race = Race::find($id);

//        if (auth()->user()->id !== $race->user_id) {
//            return false;
//        }
        $users_q = $race->appointments()->with('documents', 'personalInfo');
        $this->formTable($users_q->get());
    }

    private function formTable(Collection $users): array
    {
        $rows = [];
        foreach ($users as $user) {
            foreach($user->documents as $doc) {
                switch ($doc):
                    case 'passport':
                        $passport = $doc->document_value;
                        $rows[] = ['Серия и номер паспорта/ свидетельства о рождении' => $passport];
                        break;
                    case 'licenses':
                        $driver_license = $doc->document_value;
                        $rows[] = ['Номер ��ицензии' => $driver_license];
                        break;
                    case 'polis':
                        $moto_stamp = $doc->document_value;
                        $rows[] = ['Марка мотоцикла' => $moto_stamp];
                        break;
                    default:
                        break;
                endswitch;
            }
            $rows[] = [
                'Отметка времени'                                                   => Carbon::now()->format('d.m.Y h:m:s'),
                'Фамилия участника'                                                 => $user->personalInfo->name,
                'Имя участника'                                                     => $user->personalInfo->surname,
                'Отчество участника'                                                => $user->personalInfo->patronymic,
                'Класс'                                                             => $user->personalInfo->group,
                'Двигатель'                                                         => $user->personalInfo->engine,
                'Стартовый Номер'                                                   => $user->personalnfo->start_number,
                'Номер Лицензии'                                                    => $user,
                'Спортивное звание (разряд)'                                        => $user->personalnfo->rank,
                'Дата Рождения'                                                     => $user->personalnfo->date_of_birth,
                'Населенный пункт (город, область)'                                 => $user->personalnfo->city,
                'Команда (Клуб)'                                                    => $user->personalnfo->community,
                'Марка мотоцикла'                                                   => $user->personalnfo->moto_stamp,
                'Страховой полис: Срок действия'                                    => $user,
                'Серия и номер паспорта/ свидетельства о рождении'                  => $user,
                'Номер телефона'                                                    => $user->personalnfo->phone_number,
                'Страховой полис: Серия и номер'                                    => $user,
                'Страховой полис: Кем выдан'                                        => $user,
                'Тренер: ФИО'                                                       => $user->personalnfo->coach,
                'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'   => $user->personalnfo->inn,
                ''                                                                  => '',
                'Скан или фотография Страховки'                                     => $user,
                'Скан или фотография Лицензии'                                      => $user,
                'Скан или фотография нотариального согласия от обоих родителей'     => $user,
            ];
        }
        dd($rows);
        return $rows;
    }
}
