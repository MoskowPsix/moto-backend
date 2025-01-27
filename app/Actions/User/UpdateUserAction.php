<?php

namespace App\Actions\User;

use App\Contracts\Actions\User\UpdateUserActionContract;
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
        DB::beginTransaction();
        try {
            $user = $request->user();
            $user->update([
                'name' => $request->name ?? $user->name,
                'email' => $request->email ?? $user->email,
            ]);
            if ($request->avatar) {
                $this->delete($user->avatar);
                $this->saveImages($request->avatar, $user);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return new ErrorUpdateUserResource([]);
        } finally {
            DB::commit();
            $upd_user = User::find($user->id);
            return new SuccessUpdateUserResource($upd_user);
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

    private function delete($path): void
    {
        if (isset($path)) {
            Storage::delete($path);
        }
    }

}
