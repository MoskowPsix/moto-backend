<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceDateFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('dateStart')){
            $dateStart = request()->get('dateStart');
            $content->whereDate('date_start', '>=', $dateStart);
        }
        if(request()->has('dateEnd')){
            $dateEnd = request()->get('dateEnd');
            $content->whereDate('date_start', '<=', $dateEnd);
        }
        return $next($content);
    }
}
