<?php

namespace App\Enums;

enum DocumentType: string
{
    case Licenses = 'licenses';
    case Polis = 'polis';
    case Notarius = 'notarius';
}
