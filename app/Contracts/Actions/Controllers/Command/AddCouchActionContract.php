<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Resources\Command\AddCouch\SuccessAddCouchCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface AddCouchActionContract
{
    public function __invoke(int $command_id, int $user_id):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessAddCouchCommandResource;
}
