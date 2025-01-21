<?php

namespace App\Actions\Race;

use App\Contracts\Actions\Race\CreateRaceActionContract;
use App\Http\Requests\Race\CreateRaceRequest;
use App\Http\Resources\Race\Create\SuccessCreateRaceResource;
use App\Models\Race;
use App\Models\Track;

class CreateRaceAction implements CreateRaceActionContract
{
    public function __invoke(CreateRaceRequest $request): SuccessCreateRaceResource
    {
        $user = auth()->user();
        $race = Race::create([
            'name'          => $request->name,
            'desc'          => $request->desc,
            'date_start'    => $request->date_start,
            'track_id'        => $request->trackId,
            'user_id'        => $user->id,
        ]);
        $this->saveImages($request->images, $race);
        return SuccessCreateRaceResource::make($race);
    }

    private function saveImages( $images, Race $track): void
    {
        foreach ($images as $file) {
            $path = $file->store('race/'.$track->id, 'public');
            $path_arr[] = $path;
        }
        $track->update([
            'images' => $path_arr
        ]);
    }

}
