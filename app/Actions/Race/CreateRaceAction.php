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
            'date_start'    => $request->dateStart,
            'track_id'      => $request->trackId,
            'user_id'       => $user->id,
        ]);
        $this->saveImages($request->images, $race);
        $this->saveFile($request->positionFile, $race, 'position_file');
        $this->saveFile($request->resultsFile, $race, 'results_file');
        $race->grades()->attach($request->gradeIds);
        return SuccessCreateRaceResource::make($race);
    }

    private function saveImages( $images, Race $track): void
    {
        if (isset($image)) {
            foreach ($images as $file) {
                $path = $file->store('race/' . $track->id, 'public');
                $path_arr[] = $path;
            }
            $track->update([
                'images' => $path_arr
            ]);
        }
    }

    private function saveFile( $image, Race $race, string $field_name): void
    {
        if (isset($image)) {
            $path = $image->store('race/' . $race->id, 'public');

            $race->update([
                $field_name => $path
            ]);
        }
    }

}
