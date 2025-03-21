<?php

namespace App\Filters\Location;

use App\Filters\Pipe;
use Closure;
class LocationExistsCountRaceFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('raceCountExists')){
            $content->join('races', 'locations.id', '=', 'races.location_id')
                ->select('locations.id', 'locations.name')
                ->distinct();
        }
        return $next($content);
    }
}
