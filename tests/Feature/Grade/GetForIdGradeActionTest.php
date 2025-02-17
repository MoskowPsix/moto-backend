<?php

namespace Grade;

use App\Actions\Controllers\Grade\GetForIdGradeAction;
use App\Contracts\Actions\Controllers\Grade\GetForIdGradeActionContract;
use App\Http\Requests\Grade\GetForIdGradeRequest;
use App\Http\Resources\Grade\GetGradeForId\SuccessGetGradeForIdResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetForIdGradeActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_action_success(): void
    {
        $grade = Grade::factory()->create();
        $user = User::factory()->create();

        $gradeRequest = new GetForIdGradeRequest([
            'userId' => $user->id,
        ]);
        $action = app(GetForIdGradeActionContract::class);
        $response = $action($grade->id, $gradeRequest);
        $this->assertInstanceOf(SuccessGetGradeForIdResource::class, $response);
    }
    public function test_action_success_request_null(): void
    {
        $grade = Grade::factory()->create();

        $gradeRequest = new GetForIdGradeRequest();
        $action = app(GetForIdGradeActionContract::class);

        $response = $action($grade->id, $gradeRequest);
        $this->assertInstanceOf(SuccessGetGradeForIdResource::class, $response);
    }
}
