<?php

namespace App\Actions\Controllers\Track;

use App\Contracts\Actions\Controllers\Track\UpdateTrackActionContract;
use App\Http\Requests\Track\UpdateTrackRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Track\Update\SuccessUpdateTrackResource;
use App\Models\Track;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpdateTrackAction implements UpdateTrackActionContract
{
    public function __invoke(int $id, UpdateTrackRequest $request): SuccessUpdateTrackResource|NotFoundResource|NotUserPermissionResource
    {
        $track = Track::find($id);
        if(!$track)
        {
            return new NotFoundResource([]);
        }

        if($track->user_id !== auth()->user()->id)
        {
            return NotUserPermissionResource::make([]);
        }
        $track->update([
            'name'          => $request->name ?? $track->name,
            'address'       => $request->address ?? $track->address,
            'desc'          => $request->desc ?? $track->desc,
            'latitude'      => $request->latitude ?? $track->latitude,
            'longitude'     => $request->longitude ?? $track->longitude,
            'is_work'       => $request->is_work ?? $track->is_work,
            'level_id'      => $request->levelId ?? $track->level_id,
            'location_id'   => $request->locationId ?? $track->location_id,
            'light'         => $request->light ?? $track->light,
            'season'        => $request->season ?? $track->season,
            'store_id'      => $request->storeId ?? $track->store_id,
        ]);

        $this->saveFiles($request, $track);
        return SuccessUpdateTrackResource::make($track);
    }
    public function saveFiles(UpdateTrackRequest $request, Track $track): void
    {
        !empty($request->imagesDel) ? $this->deleteFiles($request->imagesDel, $track) : null;
        !empty($request->imagesAdd) ? $this->saveImages($request->imagesAdd, $track) : null;
        !empty($request->logo) ? $this->saveImg($request->logo, $track, 'logo') : null;
        !empty($request->schemaImg) ? $this->saveImg($request->schemaImg, $track, 'schema_img') : null;

    }

    public function saveImages(array $images, Track $track): void
    {
        $path_arr = $track->images ?? [];
        foreach ($images as $file) {
            $path = $file->store('track/'.$track->id, 'public');
            $path_arr[] = $path;
        }
        $track->update([
            'images' => $path_arr
        ]);
    }

    public function saveImg($file, Track $track, string $field): void
    {
        $path = $file->store('track/'.$track->id, 'public');
        $track->update([
            $field => $path
        ]);
    }

    public function deleteFiles($path_f, Track $track): void
    {
        foreach ($path_f as $path) {
            $track->update([
                'images' => collect($track->images)->filter(fn ($item) => $item!== $path)->toArray()
            ]);
            $this->deleteFile($path);
        }
    }
    private function deleteFile($path): void
    {
        Storage::delete($path);
    }

}
