<?php

namespace App\Filters\Track;

use App\Filters\Pipe;
use Closure;

class TrackForLocationIdsFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->get('locationId')){
            $content->where('location_id', request()->get('locationId'));
        }
        return $next($content);
    }
}
