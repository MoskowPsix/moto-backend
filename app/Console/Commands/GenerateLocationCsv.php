<?php

namespace App\Console\Commands;

use App\Contracts\Actions\Commands\GenerateLocationCsvActionContract;
use App\Models\Location;
use App\Services\GeoLocationService;
use Illuminate\Console\Command;

class GenerateLocationCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-location-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GenerateLocationCsvActionContract $action)
    {
        $action();
        return 0;
    }
}
