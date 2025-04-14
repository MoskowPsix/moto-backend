<?php

namespace App\Filters\Command;

use App\Filters\Pipe;
use Closure;

class CommandMembersInRaceExist implements Pipe
{

    public function apply($content, Closure $next)
    {
        if (request()->has('raceIdExists') && request()->has('checkMember')) {
            $raceId = request()->get('raceIdExists');
            $content->withExists(['appointments' => function ($q) use ($raceId) {
                return $q->where('races.id', $raceId);
            }]);
        }
        return $next($content);
    }
}
