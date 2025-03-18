<?php

namespace Grade;

use App\Contracts\Actions\Controllers\Grade\CreateGradeActionContract;
use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Resources\Grade\Create\SuccessCreateGradeResource;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use function PHPUnit\Framework\assertInstanceOf;

class CreateGradeActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_success(): void
    {
        $user = User::factory()->create();
        $gradeSeed = Grade::factory()->make();
        $grade = [
            'name' => $gradeSeed->name,
            'description' => $gradeSeed->description,
            'user_id' => $user->id,
        ];
        Sanctum::actingAs($user);
        $gradeRequest = new CreateGradeRequest($grade);
        $action = app(CreateGradeActionContract::class);
        $response = $action($gradeRequest);

        $this->assertInstanceOf(SuccessCreateGradeResource::class, $response);
    }
}
