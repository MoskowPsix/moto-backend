<?php

namespace App\Http\Controllers\Api;

use App\Actions\Track\GetTracksAction;
use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Track\GetTracksRequest;

class TrackController extends Controller
{
    public function get(GetTracksRequest $request, GetTracksActionContract $actionGetTrack)
    {
        return $actionGetTrack($request);
    }
    public function create()
    {}
    public function update()
    {}
    public function delete()
    {}
}
