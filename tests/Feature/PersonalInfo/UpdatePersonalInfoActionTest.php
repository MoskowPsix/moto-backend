<?php

namespace Tests\Feature\PersonalInfo;

use App\Contracts\Actions\Controllers\PersonalInfo\CreatePersonalInfoActionContract;
use App\Contracts\Actions\Controllers\PersonalInfo\UpdatePersonalInfoActionContract;
use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoResource;
use App\Models\Command;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdatePersonalInfoActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $firstUser = User::factory()->create();
        $command = Command::factory()->create();

        $personalInfoSeed = PersonalInfo::factory()->create([
            'user_id' => $firstUser->id,
            'command_id' => $command->id,
        ]);

        $personalInfo = [
            'name'              => $personalInfoSeed->name,
            'surname'           => $personalInfoSeed->surname,
            'patronymic'        => $personalInfoSeed->patronymic,
            'date_of_birth'     => $personalInfoSeed->dateOfBirth,
            'city'              => $personalInfoSeed->city,
            'inn'               => $personalInfoSeed->inn,
            'snils'             => $personalInfoSeed->snils,
            'phone_number'      => $personalInfoSeed->phoneNumber,
            'start_number'      => $personalInfoSeed->startNumber,
            'group'             => $personalInfoSeed->group,
            'rank_number'       => $personalInfoSeed->rankNumber,
            'rank'              => $personalInfoSeed->rank,
            'community'         => $personalInfoSeed->community,
            'coach'             => $personalInfoSeed->coach,
            'moto_stamp'        => $personalInfoSeed->motoStamp,
            'engine'            => $personalInfoSeed->engine,
            'user_id'           => $firstUser->id,
            'region'            => $personalInfoSeed->region,
            'number_and_seria'  => $personalInfoSeed->numberAndSeria,
            'locationId'        => $personalInfoSeed->locationId,
            'commandId'         => $command->id,
        ];
        Sanctum::actingAs($firstUser);
        $request = new UpdatePersonalInfoRequest($personalInfo);
        $action = app(UpdatePersonalInfoActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessUpdatePersonalInfoResource::class, $response);
    }
}
