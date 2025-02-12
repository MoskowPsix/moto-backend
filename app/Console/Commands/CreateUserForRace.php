<?php

namespace App\Console\Commands;

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
    public function handle()
    {
        $users = User::factory()->count($this->argument("count"))->create([
            'name' => 'test_appr'
        ]);

        $users->each(function ($user) {
            AppointmentRace::factory()->create([
                "race_id" => $this->argument("race_id"),
                "user_id" => $user->id,
            ]);
        });
        return 0;
    }
}
