<?php

namespace App\Actions\Commands;

use App\Contracts\Actions\Commands\CreateUserForRaceCommandActionContracts;
use App\Models\AppointmentRace;
use App\Models\Document;
use App\Models\PersonalInfo;
use App\Models\User;

class CreateUserForRaceCommandAction implements CreateUserForRaceCommandActionContracts
{
    public function __invoke(int $count, int $id):void
    {
        $users = User::factory()->count($count)->create([
            'name' => 'test_appr'
        ]);

        $users->each(function ($user) use ($id) {
            AppointmentRace::factory()->create([
                "race_id" => $id,
                "user_id" => $user->id,
            ]);
            PersonalInfo::factory()->create([
                "user_id" => $user->id,
            ]);
            Document::factory()->create([
                "type" => "polis",
                "user_id" => $user->id,
            ]);
            Document::factory()->create([
                "type" => "licenses",
                "user_id" => $user->id,
            ]);
            Document::factory()->create([
                "type" => "notarius",
                "user_id" => $user->id,
            ]);
        });
    }
}
