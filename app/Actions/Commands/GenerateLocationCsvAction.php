<?php

namespace App\Actions\Commands;

use App\Contracts\Actions\Commands\GenerateLocationCsvActionContract;
use App\Models\AppointmentRace;
use App\Models\Location;
use App\Models\User;
use App\Services\GeoLocationService;

class GenerateLocationCsvAction implements GenerateLocationCsvActionContract
{
    private GeoLocationService $geoService;
    private array $cache_city = [];

    private array $cache_region = [];

    private array $cache_district = [];

    public function __construct(GeoLocationService $geoService)
    {
        $this->geoService = $geoService;
    }
    public function __invoke():void
    {
        $citys = $this->geoService->getCsv();
        foreach ($citys as $city) {
            $this->saveRegion($city);
        }
    }

    private function saveRegion(object $city): void
    {
        if (!empty(array_search($city->region, $this->cache_region))) {
            return;
        }
        $this->cache_region[] = $city->region;
        Location::where('name', $city->region)->exists() ? $this->upd($city) : $this->save($city);
    }

    private function save(object $region): Location
    {
        $region_tr = $this->transformType($region->region);
        return Location::where('name', $region->region)->update([
            'name' => empty($region_tr->name) ? $region->region : $region_tr->name,
            'population' => $region->population,
            'type' => $region_tr->type,
            'time_zone' => $region->timezone,
        ]);
    }
    private function upd(object $region): bool
    {
        $region_tr = $this->transformType($region->region);
        return Location::where('name', $region->region)->update([
            'name' => empty($region->name) ? $region->region : $region_tr->name,
            'population' => $region->population,
            'type' => $region_tr->type,
            'time_zone' => $region->timezone,
        ]);
    }

    private function transformType(string $type): object
    {
        return match ($type) {
            'Респ' => (object)[
                'type' => 'Республика'
            ],
            'край' => (object)[
                'type' => 'Край'
            ],
            'АО' => (object)[
                'type' => 'Автономный округ',
            ],
            'обл' => (object)[
                'type' => 'Область'
            ],
            'г' => (object)[
                'type' => 'Город'
            ],
            'Чувашия' => (object)[
                'type' => 'Республика',
                'name' => 'Чувашская'
            ],
            'Аобл' => (object)[
                'type' => 'Автономная область'
            ],
            default => (object)[
                'type' => $type
            ],
        };
    }

}
