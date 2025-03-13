<?php

namespace App\Actions\Controllers\Auth;

use App\Contracts\Actions\Controllers\Auth\RegisterActionContract;
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
        if (User::where('email', mb_strtolower($request->email))->exists()) {
            return ErrorRegisterResource::make(['email' => 'Email already exists']);
        }
        DB::beginTransaction();
        try {
            $pass = bcrypt($request->password);
            $user =  User::create([
                'name' => $request->name,
                'password' => $pass,
                'email' => mb_strtolower($request->email),
            ]);
            if ($request->avatar) {
                $this->saveImages($request->avatar, $user);
            }
            DB::commit();
            return SuccessRegisterResource::make($user);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            return ErrorRegisterResource::make([]);
        }
    }

    private function saveImages( $image, User $user): void
    {
        $path = $image->store('user/'.$user->id, 'public');
        $path_arr[] = $path;

        $user->update([
            'avatar' => $path_arr
        ]);
    }
}
