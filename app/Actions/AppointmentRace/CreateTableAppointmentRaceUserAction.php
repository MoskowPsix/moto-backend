<?php

namespace App\Actions\AppointmentRace;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Models\Race;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class CreateTableAppointmentRaceUserAction implements  CreateTableAppointmentRaceUserActionContract
{

    public function __invoke(int $id)
    {
//        $race = Race::find($id);

//        if (auth()->user()->id !== $race->user_id) {
//            return false;
//        }
//        $users_q = $race->appointments()->with('documents', 'personalInfo');
        $this->formTable(User::where('id', 3)->get());
    }

    private function formTable(Collection $users): array
    {
        $rows = [];
        foreach ($users as $user) {
//            dump($user->documents->toArray());
            foreach($user->documents as $doc) {
                switch ($doc->type):
                    case 'pasport':
                        $passport = [
                            'serial'    => $doc->data['numberAndSeria'],
                            'url'       => $doc->data['fileLink']
                        ];
                        break;
                    case 'licenses':
                        $license = [
                            'number'    => $doc->data['licensesNumber'],
                            'url'       => $doc->data['fileLink'],
                        ];
                        break;
                    case 'polis':
                        $polis = [
                            'number'        => $doc->data['polisNumber'],
                            'issuedWhom'    => $doc->data['issuedWhom'],
                            'itWorksDate'    => $doc->data['itWorksDate'],
                            'url'           => $doc->data['fileLink'],
                        ];
                        break;
                    default:
                        break;
                endswitch;
            }
//            dd($user->personalInfo->start_number);
            $rows[] = [
                'Отметка времени'                                                   => Carbon::now()->format('d.m.Y h:m:s'),
                'Фамилия участника'                                                 => $user->personalInfo->name,
                'Имя участника'                                                     => $user->personalInfo->surname,
                'Отчество участника'                                                => $user->personalInfo->patronymic,
                'Класс'                                                             => $user->personalInfo->group,
                'Двигатель'                                                         => $user->personalInfo->engine,
                'Стартовый Номер'                                                   => $user->personalnfo->start_number,
                'Номер Лицензии'                                                    => $license['number'],
                'Спортивное звание (разряд)'                                        => $user->personalnfo->rank,
                'Дата Рождения'                                                     => $user->personalnfo->date_of_birth,
                'Населенный пункт (город, область)'                                 => $user->personalnfo->city,
                'Команда (Клуб)'                                                    => $user->personalnfo->community,
                'Марка мотоцикла'                                                   => $user->personalnfo->moto_stamp,
                'Страховой полис: Срок действия'                                    => $polis['itWorksDate'],
                'Серия и номер паспорта/ свидетельства о рождении'                  => $passport['serial'],
                'Номер телефона'                                                    => $user->personalnfo->phone_number,
                'Страховой полис: Серия и номер'                                    => $polis['number'],
                'Страховой полис: Кем выдан'                                        => $polis['issuedWhom'],
                'Тренер: ФИО'                                                       => $user->personalnfo->coach,
                'ИНН (для спортсменов младше 18 лет указываем ИНН представителя)'   => $user->personalnfo->inn,
                ''                                                                  => '',
                'Скан или фотография Страховки'                                     => $polis['url'],
                'Скан или фотография Лицензии'                                      => $license['url'],
                'Скан или фотография нотариального согласия от обоих родителей'     => '',
            ];
        }
        dd($rows);
        return $rows;
    }
}
