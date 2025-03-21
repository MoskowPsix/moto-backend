<?php

namespace App\Actions\Controllers\Auth;

use App\Contracts\Actions\Controllers\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Http\Resources\Error\Login\ErrorEmailExistsResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginAction implements LoginActionContract
{
    /**
     * @throws Exception
     */
    public function __invoke(LoginRequest $request): SuccessLoginResource|ErrorLoginResource|ErrorEmailExistsResource
    {
        try {
            if (!User::where('email', mb_strtolower($request->email))->exists()){
                return ErrorEmailExistsResource::make([]);
            }
            $user = User::with('roles', 'phone', 'personalInfo')->where('email', mb_strtolower($request->email))->firstOrFail();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return  ErrorLoginResource::make([]);
            }
            return SuccessLoginResource::make($user);
        } catch (\Exception $e) {
            return ErrorLoginResource::make([]);
        }
    }
}
