<?php

namespace Grade;

use App\Contracts\Actions\Controllers\Grade\GetGradeActionContract;
use App\Http\Requests\Grade\GetGradeRequest;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetGradeActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $grade = Grade::factory()->create();
        $user = User::factory()->create();

        $gradeRequest = new GetGradeRequest([
            'userId' => $user->id,
            'paginate' => 0,
            'page' => 1,
            'limit' => 10,
        ]);

        $action = app(GetGradeActionContract::class);
        $response = $action($gradeRequest);
        $this->assertInstanceOf(SuccessGetGradeResource::class, $response);
    }

    public function test_action_success_with_pagination(): void
    {
        $grade = Grade::factory()->create();
        $user = User::factory()->create();

        $gradeRequest = new GetGradeRequest([
            'userId' => $user->id,
            'paginate' => 1,
            'page' => 1,
            'limit' => 10,
        ]);

        $action = app(GetGradeActionContract::class);
        $response = $action($gradeRequest);
        $this->assertInstanceOf(SuccessGetGradeResource::class, $response);
    }

    public function test_action_success_null(): void
    {
        $gradeRequest = new GetGradeRequest();

        $action = app(GetGradeActionContract::class);
        $response = $action($gradeRequest);
        $this->assertInstanceOf(SuccessGetGradeResource::class, $response);
    }
}
