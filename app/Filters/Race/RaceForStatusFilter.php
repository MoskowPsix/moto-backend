<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;


class RaceForStatusFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->get('statusIds')){
            $content->whereHas('status', function ($q) {
                $q->whereIn('id', request()->get('statusIds'));
            });
        }
        return $next($content);
    }
}
