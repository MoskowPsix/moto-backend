<?php

namespace App\Contracts\Actions\Controllers\User;

interface DeleteUserActionContract
{
    public function __invoke(): \App\Http\Resources\User\Delete\SuccessUserDeleteResource;
}
