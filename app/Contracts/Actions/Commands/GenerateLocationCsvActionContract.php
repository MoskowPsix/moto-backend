<?php

namespace App\Contracts\Actions\Commands;

use App\Services\GeoLocationService;

interface GenerateLocationCsvActionContract
{
    public function __invoke():void;

}
