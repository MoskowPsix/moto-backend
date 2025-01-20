<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Track\CreateTracksActionContract;
use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\Create\ErrorCreateResource;
use App\Http\Resources\Track\Create\SuccessCreateResource;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Models\Track;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\Authenticated;


#[Group(name: 'Track', description: 'Методы взаимодествия с трассами на которых проходят гонки')]
class TrackController extends Controller
{
    #[ResponseFromApiResource(SuccessGetTracksResource::class, Track::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение трасс по фильтрам')]
    public function get(GetTracksRequest $request, GetTracksActionContract $actionGetTrack): SuccessGetTracksResource
    {
        return $actionGetTrack($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateResource::class, Track::class, collection: false)]
    #[ResponseFromApiResource(ErrorCreateResource::class, status: 422)]
    #[Endpoint(title: 'create', description: 'Метод создания трека')]
    public function create(CreateTrackRequest $request, CreateTracksActionContract $actionCreateTrack): SuccessCreateResource | ErrorCreateResource
    {
        return $actionCreateTrack($request);
    }
//    public function update()
//    {}
//    public function delete()
//    {}
}
