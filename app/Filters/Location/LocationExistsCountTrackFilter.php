<?php

namespace App\Filters\Location;

use App\Filters\Pipe;
use Closure;

class LocationExistsCountTrackFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('trackCountExists')){
            $content->join('tracks', 'locations.id', '=', 'tracks.location_id')
                ->select('locations.id', 'locations.name')
                ->distinct();
        }
        return $next($content);
    }
}
