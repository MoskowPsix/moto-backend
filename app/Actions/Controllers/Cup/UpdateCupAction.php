<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\UpdateCupActionContract;
use App\Http\Requests\Cup\UpdateCupRequest;
use App\Http\Resources\Cup\Update\SuccessUpdateCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Cup;
use Illuminate\Support\Facades\Storage;

class UpdateCupAction implements UpdateCupActionContract
{

    public function __invoke(int $id, UpdateCupRequest $request): SuccessUpdateCupResource|NotFoundResource|NotUserPermissionResource
    {
        $cup = Cup::find($id);
        if(!isset($cup))
        {
            return NotFoundResource::make([]);
        }
        if($cup->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $cup->update([
            'name'          => $request->name ?? $cup->name,
            'year'          => $request->year ?? $cup->year,
            'stages'        => $request->stages ?? $cup->stages,
            'color'         => $request->color ?? $cup->color,
            'location_id'   => $request->locationId ?? $cup->location_id,
            'user_id'       => $request->userId ?? $cup->user_id,
        ]);
        $this->saveImage($request->image, $cup);
        return SuccessUpdateCupResource::make($cup);
    }
    private function saveImage($image, Cup $cup): void
    {
        if($image){
            $this->deleteImage($cup);
        }
        $path = $image->store('cup/' . $cup->id, 'public');
        $cup->update(['image' => $path]);
    }
    private function deleteImage(Cup $cup): void
    {
        if ($cup->image) {
            Storage::delete($cup->image);
        }
    }
}
