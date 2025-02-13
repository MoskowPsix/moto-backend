<?php

namespace App\Contracts\Actions\Commands;

interface CreateUserForRaceCommandActionContracts
{
    public function __invoke(int $count, int $id):void;

}
