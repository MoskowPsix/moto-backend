<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceForDegreeFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('degreeIds')){
            $content->whereHas('cups', function ($q)  {
                $q->whereHas('degree', function ($q)  {
                   $q->whereIn('id', request()->get('degreeIds'));
                });
            });
        }
        return $next($content);
    }
}
