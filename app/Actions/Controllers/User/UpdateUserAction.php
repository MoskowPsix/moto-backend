<?php

namespace App\Actions\Controllers\User;

use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Http\Resources\User\Update\SuccessUpdateUserResource;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserAction implements UpdateUserActionContract
{
    public function __invoke(UpdateUserRequest $request): SuccessUpdateUserResource | ErrorUpdateUserResource
    {
        $user = auth()->user();
        if(empty($user)) {
            return new ErrorUpdateUserResource([]);
        }
        $emailChanged = isset($request->email) && $request->email !== $user->email;

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
        ]);

        if ($request->avatar) {
            $this->delete($user->avatar);
            $this->saveImages($request->avatar, $user);
        }
        if (isset($request->number)) {
            if ($user->phone()->exists()) {
                $user->phone()->update([
                    'number' => $request->number,
                    'last_num' => substr($request->number, -4),
                ]);
            } else {
                $user->phone()->create([
                    'number' => $request->number,
                    'last_num' => substr($request->number, -4),
                ]);
            }
        }
        $upd_user = User::find($user->id);
        return new SuccessUpdateUserResource($upd_user);
    }

    private function saveImages( $image, User $user): void
    {
        $path = $image->store('user/'.$user->id, 'public');

        $user->update([
            'avatar' => $path
        ]);
    }

    private function delete($path): void
    {
        if (isset($path)) {
            Storage::delete($path);
        }
    }

}
