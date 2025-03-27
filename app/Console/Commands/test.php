<?php

namespace App\Console\Commands;

use App\Enums\DocumentType;
use App\Models\Document;
use App\Models\Phone;
use App\Models\User;
use App\Services\GoogleSheetService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

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
     * @throws \Exception
     */
    public function handle()
    {
        \App\Models\Command::query()->each(function ($command) {
            $command->coaches()->attach($command->user_id);
        });
        return 0;
    }
}
