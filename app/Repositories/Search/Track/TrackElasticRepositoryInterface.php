<?php

namespace App\Repositories\Search\Track;

use Illuminate\Database\Eloquent\Collection;

interface TrackElasticRepositoryInterface
{
    public function search(string $query = ''): object;
}
