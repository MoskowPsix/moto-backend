<?php

namespace App\Actions\Track;

use App\Contracts\Actions\Track\CreateTracksActionContract;
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
                'name' => $request->name,
                'address' => $request->address,
                'point' => 'POINT(' . $request->latitude . ' ' . $request->longitude . ')'
            ]);
            $this->saveImages($request->images, $track);
            DB::commit();
            return SuccessCreateResource::make($track); // Возвращает нулевые координаты, потом надо исправить, пока не критично
        } catch (Exception $e) {
            DB::rollBack();
            return ErrorCreateResource::make([]);
        }
    }

    private function saveImages(array $images, Track $track): void
    {
        foreach ($images as $file) {
            $path = $file->store('track/'.$track->id, 'public');
            $path_arr[] = $path;
        }
        $track->update([
            'images' => $path_arr
        ]);
    }
}
