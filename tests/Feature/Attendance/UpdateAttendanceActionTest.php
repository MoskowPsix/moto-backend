<?php

namespace Tests\Feature\Attendance;

use App\Contracts\Actions\Controllers\Attendance\UpdateAttendanceActionContract;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\Attendance\Update\SuccessUpdateAttendanceResource;
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

class UpdateAttendanceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_not_user_permission(): void
    {
        $track = Track::factory()->create();
        $user = User::factory()->create();

        $attendance_seed = Attendance::factory()->create([
            'track_id' => $track->id,
        ]);

        $attendance = [
            'name'          => $attendance_seed->name,
            'desc'          => $attendance_seed->desc,
            'price'         => $attendance_seed->price,
            'trackId'       => $track->id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateAttendanceRequest($attendance);

        $action = app(UpdateAttendanceActionContract::class);
        $response = $action($attendance_seed->id, $request);

        $this->assertInstanceOf(NotUserPermissionResource::class, $response);
    }

    public function test_action_not_found(): void
    {
        $track = Track::factory()->create();
        $user = User::factory()->create();

        $attendance_seed = Attendance::factory()->create([
            'track_id' => $track->id,
        ]);

        $attendance = [
            'name'          => $attendance_seed->name,
            'desc'          => $attendance_seed->desc,
            'price'         => $attendance_seed->price,
            'trackId'       => $track->id,
        ];
        Sanctum::actingAs($user);
        $request = new UpdateAttendanceRequest($attendance);

        $action = app(UpdateAttendanceActionContract::class);
        $response = $action(-1, $request);

        $this->assertInstanceOf(NotFoundResource::class, $response);
    }

}
