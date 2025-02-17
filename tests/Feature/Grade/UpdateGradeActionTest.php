<?php

namespace Grade;

use App\Contracts\Actions\Controllers\Grade\CreateGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\UpdateGradeActionContract;
use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Grade\Create\SuccessCreateGradeResource;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateGradeActionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_action_not_found(): void
    {
        $user = User::factory()->create();
        $gradeSeed = Grade::factory()->make();
        $grade = [
            'name' => $gradeSeed->name,
            'description' => $gradeSeed->description,
            'userId' => $user->id,
        ];
        Sanctum::actingAs($user);
        $gradeRequest = new UpdateGradeRequest($grade);
        $action = app(UpdateGradeActionContract::class);
        $response = $action($user->id, $gradeRequest);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_not_permission(): void
    {
        $user = User::factory()->create();
        $gradeSeed = Grade::factory()->create();
        $grade = [
            'name' => $gradeSeed->name,
            'description' => $gradeSeed->description,
            'userId' => $user->id,
        ];
        Sanctum::actingAs($user);
        $gradeRequest = new UpdateGradeRequest($grade);
        $action = app(UpdateGradeActionContract::class);
        $response = $action($gradeSeed->id, $gradeRequest);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $gradeSeed = Grade::factory()->create([
            'user_id' => $user->id,
        ]);

        $grade = [
            'name' => $gradeSeed->name,
            'description' => $gradeSeed->description,
            'userId' => $user->id,
        ];
        Sanctum::actingAs($user);
        $gradeRequest = new UpdateGradeRequest($grade);

        $action = app(UpdateGradeActionContract::class);
        $response = $action($gradeSeed->id, $gradeRequest);

        $this->assertInstanceOf(SuccessUpdateGradeResource::class, $response);
    }
}
