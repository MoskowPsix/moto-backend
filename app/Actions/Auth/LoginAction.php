<?php

namespace App\Actions\Auth;

use App\Contracts\Actions\Auth\LoginActionContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class LoginAction implements LoginActionContract
{
    /**
     * @throws Exception
     */
    public function __invoke(LoginRequest $request): SuccessLoginResource | ErrorLoginResource
    {
        try {
            $user = User::with('roles')->where('email', $request->email)->firstOrFail();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw new Exception('Login failed');
            }
            return SuccessLoginResource::make($user);
        } catch (\Exception $e) {
            return ErrorLoginResource::make([]);
        }
    }
}
