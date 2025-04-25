<?php

namespace App\Filters\Track;

use App\Filters\Pipe;
use Closure;

class TrackStoreExists implements Pipe
{

    public function apply($content, Closure $next)
    {
        if(request()->has('storeIdExists') && request()->has('checkStore')){
            $storeId = request()->get('storeIdExists');

            $content->withExists(['store' => function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            }]);
        }
        return $next($content);
    }
}
