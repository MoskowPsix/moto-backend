<?php

namespace Tests\Feature\PersonalInfo;

use App\Contracts\Actions\Controllers\PersonalInfo\CreatePersonalInfoActionContract;
use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;
use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreatePersonalInfoActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $personalInfoSeed = PersonalInfo::factory()->make();
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
            'user_id'           => $user->id,
            'region'            => $personalInfoSeed->region,
            'number_and_seria'  => $personalInfoSeed->numberAndSeria,
            'locationId'        => $personalInfoSeed->locationId,
            'commandId'         => $personalInfoSeed->commandId,
        ];
        Sanctum::actingAs($user);
        $request = new CreatePersonalInfoRequest($personalInfo);
        $action = app(CreatePersonalInfoActionContract::class);
        $response = $action($request);

        $this->assertInstanceOf(SuccessCreatePersonalInfoResource::class, $response);
    }
}
