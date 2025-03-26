<?php

namespace App\Filters\Command;

use App\Filters\Pipe;
use Closure;

class CommandCoachExist implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->has('userIdExists') && request()->has('checkCoach')) {
            $userId = request()->get('userIdExists');

            $content->withExists(['coaches' => function ($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }
        return $next($content);
    }
}
