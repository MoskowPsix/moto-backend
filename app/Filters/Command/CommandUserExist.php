<?php

namespace App\Filters\Command;

use App\Filters\Pipe;
use Closure;

class CommandUserExist implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->has('userIdExists') && request()->has('checkMember')) {
            $userId = request()->get('userIdExists');

            $content->withExists(['members' => function ($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }
        return $next($content);
    }
}
