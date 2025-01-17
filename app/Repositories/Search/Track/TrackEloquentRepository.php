<?php

namespace App\Repositories\Search\Track;

use App\Models\Track;

class TrackEloquentRepository implements TrackElasticRepositoryInterface
{
    public function search(string $query = ''): object
    {
        return Track::query()
//            ->where('body', 'like', "%{$query}%")
//            ->orWhere('title', 'like', "%{$query}%")
            ->get();
    }
}
