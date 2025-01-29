<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Carbon\Carbon;
use Closure;

class RaceForTrackFilter implements Pipe
{

    public function apply($content, Closure $next)
    {
        if (request()->has('trackId')) {
            $trackId = request()->get('trackId');
            $content = $content->where('track_id', $trackId);
            $date = Carbon::now()->format('Y-m-d H:i:s');
            if(request()->has('pastRace')) {
                $content->whereDate('date_start', '<=', $date);
            } else {
                $content->whereDate('date_start', '>=', $date);
            }
        }

        return $next($content);
    }

}
