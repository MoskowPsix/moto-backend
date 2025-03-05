<?php

namespace App\Filters\Attendance;

use App\Filters\Pipe;
use Closure;

class AttendanceTrackIdFilter implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->has('trackId')){
            $content->where('track_id', request()->get('trackId'));
        }
        return $next($content);
    }
}
