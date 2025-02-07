<?php

namespace App\Console\Commands;

use App\Contracts\Services\GoogleSheetServiceContract;
use App\Models\Race;
use App\Services\GoogleSheetService;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table_name = 'тестовая таблица';
        $race = Race::find(1);

        $fields =
        [

        ];
        $values = [
            [

            ]
        ];

        $service = app(GoogleSheetServiceContract::class);
        $result = $service->create($table_name, $fields, $values, $race);

        dd($result);
    }
}
