<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\UpdateRaceActionContract;
use App\Http\Requests\Race\UpdateRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Update\SuccessUpdateRaceResource;
use App\Models\Race;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UpdateRaceAction implements UpdateRaceActionContract
{

    public function __invoke(int $id, UpdateRaceRequest $request): SuccessUpdateRaceResource|NotFoundResource|NotUserPermissionResource
    {
        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        if ($race->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }
        $race->update([
            'name'              => $request->name ?? $race->name,
            'desc'              => $request->desc ?? '',
            'record_start'      => Carbon::parse($request->recordStart) ?? $race->recordStart,
            'record_end'        => Carbon::parse($request->recordEnd) ?? $race->recordEnd,
            'date_start'        => Carbon::parse($request->get('dateStart')) ?? $race->date_start,
            'track_id'          => $request->get('trackId') ?? $race->track_id,
            'location_id'       => $request->locationId ?? $race->location_id,
            'status_id'         => $request->statusId ?? $race->status_id,
        ]);
        $this->saveFiles($request, $race);
        $race->grades()->sync($request->gradeIds);
        if (isset($request->cupIds)) {
            $race->cups()->sync($request->cupIds);
        }

        return SuccessUpdateRaceResource::make($race);
    }

    private function saveFiles(UpdateRaceRequest $request, Race $race): void
    {
        !empty($request->imagesDel) ? $this->deleteFiles($request->imagesDel, $race) : null;
        !empty($request->imagesAdd) ? $this->saveImages($request->imagesAdd, $race) : null;

        if (!empty($request->positionFile)) {
            isset($race->positionFile) ? $this->deleteFile($race->positionFile) : null;
            $race->update([
                'position_file' => $request->positionFile->store('race/'.$race->id, 'public')
            ]);
        }

        if (!empty($request->resultsFile)) {
            isset($race->results_file) ? $this->deleteFile($race->results_file) : null;
            $race->update([
                'results_file' => $request->resultsFile->store('race/'.$race->id, 'public')
            ]);
        }
    }

    private function saveImages(array $images, Race $race): void
    {
        $path_arr = $race->images;
        foreach ($images as $file) {
            $path = $file->store('race/'.$race->id, 'public');
            $path_arr[] = $path;
        }
        $race->update([
            'images' => $path_arr
        ]);
    }

    private function deleteFiles($path_arr, Race $race): void
    {
        foreach ($path_arr as $path) {
            $race->update([
                'images' => collect($race->images)->filter(fn ($item) => $item!== $path)->toArray()
            ]);
            $this->deleteFile($path);
        }
    }

    private function deleteFile($path): void
    {
        Storage::delete($path);
    }
}
