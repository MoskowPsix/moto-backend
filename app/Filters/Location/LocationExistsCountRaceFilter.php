<?php

namespace App\Filters\Location;

use App\Filters\Pipe;
use Closure;
class LocationExistsCountRaceFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->get('raceCountExists')){
            dump('race');
            $content->join('races', 'locations.id', '=', 'races.location_id')
                ->select('locations.id', 'locations.name', 'locations.type', )
                ->distinct();
        }
        return $next($content);
    }
}
