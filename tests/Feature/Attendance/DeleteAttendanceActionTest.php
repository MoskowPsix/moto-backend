<?php

namespace Tests\Feature\Attendance;

use App\Contracts\Actions\Controllers\Attendance\DeleteAttendanceActionContract;
use App\Http\Requests\Attendance\DeleteAttendanceRequest;
use App\Http\Resources\Attendance\Delete\SuccessDeleteAttendanceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Attendance;
use App\Models\Track;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteAttendanceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_action_not_found(): void
    {
        $attendance = Attendance::factory()->create();

        $request = new DeleteAttendanceRequest();
        $action = app(DeleteAttendanceActionContract::class);

        $response = $action(-1, $request);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

    public function test_action_not_permission(): void
    {
        $attendance = Attendance::factory()->create();
        $user = User::factory()->create();
        $request = new DeleteAttendanceRequest();
        $action = app(DeleteAttendanceActionContract::class);
        Sanctum::actingAs($user);
        $response = $action($attendance->id, $request);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }
    public function test_action_success(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $track = Track::factory()->create([
            'user_id' => $user->id,
        ]);

        $attendance = Attendance::factory()->create([
            'track_id' => $track->id,
        ]);

        $request = new DeleteAttendanceRequest();
        $action = app(DeleteAttendanceActionContract::class);
        $response = $action($attendance->id, $request);

        $this->assertInstanceOf(SuccessDeleteAttendanceResource::class, $response);
    }
}
