<?php

namespace App\Actions\Controllers\Command;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Command\AddCouchActionContract;
use App\Http\Resources\Command\AddCouch\SuccessAddCouchCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;

class AddCouchAction implements AddCouchActionContract
{
    public function __invoke(int $command_id, int $user_id):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessAddCouchCommandResource
    {
        $author = auth()->user();
        $command = Command::find($command_id);
        if (!isset($command)) {
            return NotFoundResource::make([]);
        }
        if ($author->id !== $command->user_id && !$author->hasRole(RoleConstant::ROOT)) {
            return NotUserPermissionResource::make([]);
        }
        $user = User::find($user_id);
        if (!isset($user)) {
            return NotFoundResource::make([]);
        }
        if (!$user->hasRole(RoleConstant::COUCH)) {
            return NotUserPermissionResource::make([]);
        }
        $result = $command->coaches()->toggle($user_id);
        return SuccessAddCouchCommandResource::make(!empty($result['attached']));
    }
}
