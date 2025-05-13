<?php

namespace App\Actions\Controllers\Track;

use App\Contracts\Actions\Controllers\Track\CreateTracksActionContract;
use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Resources\Track\Create\ErrorCreateResource;
use App\Http\Resources\Track\Create\SuccessCreateResource;
use App\Models\Track;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateTracksAction implements CreateTracksActionContract
{
    public function __invoke(CreateTrackRequest $request): SuccessCreateResource | ErrorCreateResource
    {
        DB::beginTransaction();
        try {
            $track = Track::create([
                'name'          => $request->name,
                'address'       => $request->address,
                'point'         => 'POINT(' . $request->latitude . ' ' . $request->longitude . ')',
                'level_id'      => $request->levelId,
                'desc'          => $request->desc ?? '',
                'length'        => $request->length,
                'turns'         => $request->turns,
                'free'          => isset($request->free),
                'is_work'       => isset($request->is_work),
                'spec'          => $request->spec,
                'contacts'      => $request->contacts ?? json_encode([]),
                'user_id'       => auth()->user()->id,
                'location_id'   => $request->locationId,
                'light'         => isset($request->light),
                'season'        => isset($request->season),
                'store_id'      => $request->storeId,
            ]);
            if(isset($request->images)) {
                $this->saveImages($request->images, $track);
            }
            if(isset($request->logo)) {
                $path_l = $request->logo->store('track/'.$track->id, 'public');
                $track->update([
                    'logo' => $path_l
                ]);
            }
            if(isset($request->schemaImg)) {
                $path_s = $request->schemaImg->store('track/'.$track->id, 'public');
                $track->update([
                    'schema_img' => $path_s
                ]);
            }
            if(isset($request->offerFile)){
                $this->saveFile($request->offerFile, $track, 'offer_file');
            }
            $this->saveRequisitesData($request, $track);
            DB::commit();
            return SuccessCreateResource::make($track); // Возвращает нулевые координаты, потом надо исправить, пока не критично
        } catch (Exception $e) {
            DB::rollBack();
            return ErrorCreateResource::make([]);
        }
    }

    private function saveImages( $images, Track $track): void
    {
        foreach ($images as $file) {
            $path = $file->store('track/'.$track->id, 'public');
            $path_arr[] = $path;
        }
        $track->update([
            'images' => $path_arr
        ]);
    }
    private function saveFile($file, Track $track, string $field_name): void
    {
        if (isset($file)) {
            $path = $file->store('track/' . $track->id, 'public');

            $track->update([
                $field_name => $path,
            ]);
        }
    }
    private function saveRequisitesData(CreateTrackRequest $request, Track $track): void
    {
        if($request->has('requisitesName') || $request->has('requisitesPhone') || $request->has('requisitesEmail'))
        {
            $date = [
                'name'  => $request->input('requisitesName'),
                'phone' => $request->input('requisitesPhone'),
                'email' => $request->input('requisitesEmail'),
                'inn'   => $request->input('requisitesINN'),
            ];
            $track->update([
                'requisites_file' => $date,
            ]);
        }
    }
}
