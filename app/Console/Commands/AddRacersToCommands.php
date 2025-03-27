<?php

namespace App\Console\Commands;

use App\Constants\RoleConstant;
use Illuminate\Console\Command;

class AddRacersToCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-racers-to-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление гонщиков в команды';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\AppointmentRace::query()->each(function ($racer) {
            $user = $racer->user;

            if ($user && $user->personalInfo && $user->personalInfo->command_id) {
                $commandId = $user->personalInfo->command_id;

                $command = \App\Models\Command::find($commandId);
                if($command) {
                    $command->members()->syncWithoutDetaching($user->id);
                    $this->info("Гонщик {$user->id} добавлен в команду {$commandId}");
                }
                else {
                    $this->warn("Команда с ID {$commandId} не найдена для гонщика {$user->id}");
                }
            }
            else {
                $this->warn("У гонщика {$user->id} нет данных personalInfo или command_id");
            }
        });
        return 0;
    }
}

