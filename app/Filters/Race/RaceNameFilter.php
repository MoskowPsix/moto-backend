<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceNameFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('name')) {
            $content->where('name', 'ilike', '%' .request()->get('name') . '%');
        }
        return $next($content);
    }
}
