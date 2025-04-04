<?php

namespace App\Constants;

class RoleConstant extends Constants
{
    public const ROOT           = 'Root'; // Все права над всеми сущностями.
    public const ADMIN          = 'Admin'; // Все права над всеми сущностями, кроме удаления.
    public const COMMISSION     = 'Commission'; // Индивидуально право на просмотр информации заявившихся на гонку.
    public const COUCH          = 'Couch'; // Право взаимодействовать с командами.
    public const RIDER          = 'Rider'; // Запись на трассу, гонку, возможность создавать и вступать в команды
    public const ORGANIZATION   = 'Organization'; // Запись на трасcу, гонку, возможность создавать и вступать в команды, создание трасс и гонок
}
