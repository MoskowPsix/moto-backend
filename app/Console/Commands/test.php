<?php

namespace App\Console\Commands;

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
        $id = '1zZNXPBPChXKMkgUAwidbvdW1OzNwtsO7yzbDtNU5bHg';
        $service = new GoogleSheetService();
//        $url = $service->create('Тестовая таблица', ['id', 'name', 'email'], [
//            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
//            ['id' => 2, 'name' => 'Jane Doe', 'email' => 'jane.doe@example.com'],
//        ]);
        $rows = [];
        for ($i = 1; $i <= 10; $i++) {
            $rows[] = ['id' => $i, 'name' => 'User '. $i, 'email' => 'user'. $i. '@example.com'];
        }
        $url = $service->update($id, ['id', 'name', 'email'], $rows);
        dump($url);
        return 1;
    }
}
