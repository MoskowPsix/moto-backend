<?php

namespace App\Filters\Location;

use App\Filters\Pipe;
use Closure;

class LocationCommandExists implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->get('commandCountExists')){
            $content->join('commands', 'locations.id', '=', 'commands.location_id')
                ->select('locations.id', 'locations.name', 'locations.type', )
                ->distinct();
        }
        return $next($content);
    }
}
