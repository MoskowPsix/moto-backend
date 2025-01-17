<?php

namespace App\Http\Controllers\Api;

use App\Actions\Track\GetTracksAction;
use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Role\GetChangeRole\SuccessGetChangeRoleResource;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Models\Track;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\Permission\Models\Role;

#[Group(name: 'Track', description: 'Методы взаимодествия с трассами на которых проходят гонки')]
class TrackController extends Controller
{
    #[ResponseFromApiResource(SuccessGetTracksResource::class, Track::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение трасс по фильтрам')]
    public function get(GetTracksRequest $request, GetTracksActionContract $actionGetTrack): SuccessGetTracksResource
    {
        return $actionGetTrack($request);
    }
//    public function create()
//    {}
//    public function update()
//    {}
//    public function delete()
//    {}
}
