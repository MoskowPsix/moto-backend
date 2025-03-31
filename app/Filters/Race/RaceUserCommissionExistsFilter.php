<?php

namespace App\Filters\Race;

use App\Filters\Pipe;
use Closure;

class RaceUserCommissionExistsFilter implements Pipe
{
    public function apply($content, Closure $next)
    {
        if(request()->has('userIdExists') && request()->has('commissionUser')){
            $userId = request()->get('userIdExists');
            $content->withExists(['commissions' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }

        return $next($content);
    }
}
