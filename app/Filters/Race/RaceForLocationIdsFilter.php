<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;


class RaceForLocationIdsFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('LocationId')){
            $content->whereHas('track', function ($q) {
                $q->where('location_id', request()->get('LocationId'));
            });
        }
        return $next($content);
    }
}
