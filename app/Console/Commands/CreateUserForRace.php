<?php

namespace App\Console\Commands;

use App\Actions\Commands\CreateUserForRaceCommandAction;
use App\Models\AppointmentRace;
use App\Models\User;
use Illuminate\Console\Command;

class CreateUserForRace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user-for-race {race_id} {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CreateUserForRaceCommandAction $action)
    {
        $count = $this->argument('count');
        $race_id = $this->argument('race_id');
        $action($count, $race_id);
        return 0;
    }
}
