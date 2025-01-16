<?php

namespace App\Constants;

class RoleConstant extends Constants
{
    public const ROOT           = 'Root'; // Все права над всеми сущностями.
    public const ADMIN          = 'Admin'; // Все права над всеми сущностями, кроме удаления.
    public const RIDER          = 'Rider'; // Запись на трасу, гонку, возможность создавать и вступать в команды
    public const Organization   = 'Organization'; // Запись на трасу, гонку, возможность создавать и вступать в команды, создание трасс и гонок
}
