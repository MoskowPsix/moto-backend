<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\CreateRaceActionContract;
use App\Http\Requests\Race\CreateRaceRequest;
use App\Http\Resources\Race\Create\SuccessCreateRaceResource;
use App\Models\Race;
use App\Models\Track;
use Carbon\Carbon;

class CreateRaceAction implements CreateRaceActionContract
{
    public function __invoke(CreateRaceRequest $request): SuccessCreateRaceResource
    {
        $user = auth()->user();
        $race = Race::create([
            'name'          => $request->name,
            'desc'          => $request->desc ?? '',
            'date_start'    => $request->dateStart,
            'track_id'      => $request->trackId,
            'record_start'  => isset($request->recordStart) ? Carbon::parse($request->recordStart) : null,
            'record_end'    => isset($request->recordEnd) ? Carbon::parse($request->recordEnd) : null,
            'user_id'       => $user->id,
            'location_id'   => $request->locationId ?? Track::find($request->locationId)->location_id,
            'status_id'     => $request->statusId,
        ]);
        $this->saveImages($request->images, $race);
        $this->saveFile($request->positionFile, $race, 'position_file');
        $this->saveFile($request->resultsFile, $race, 'results_file');
        $this->saveFile($request->pdfFiles, $race, 'pdf_file');
        $race->grades()->attach($request->gradeIds);
        $race->cups()->attach($request->cupIds);
        return SuccessCreateRaceResource::make($race);
    }

    private function saveImages( $images, Race $track): void
    {
        if($images) {
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
