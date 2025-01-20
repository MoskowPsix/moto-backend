<?php

namespace App\Actions\Auth;

use App\Contracts\Actions\Auth\RegisterActionContract;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterAction implements RegisterActionContract
{
    /**
     * @throws Exception
     */
    public function __invoke(RegisterRequest $request): ErrorRegisterResource | SuccessRegisterResource
    {
        DB::beginTransaction();
        try {
            $pass = bcrypt($request->password);
            $user =  User::create([
                'name' => $request->name,
                'password' => $pass,
                'email' => $request->email,
                'avatar' => $request->avatar,
            ]);
            DB::commit();
            return SuccessRegisterResource::make($user);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ErrorRegisterResource::make([]);
        }
    }
}
