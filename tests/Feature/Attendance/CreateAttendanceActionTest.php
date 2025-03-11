<?php

namespace Tests\Feature\Attendance;

use App\Contracts\Actions\Controllers\Attendance\CreateAttendanceActionContract;
use App\Http\Requests\Attendance\CreateAttendanceRequest;
use App\Http\Resources\Attendance\Create\SuccessCreateAttendanceResource;
use App\Models\Attendance;
use App\Models\Track;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateAttendanceActionTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;
    /**
     * A basic feature test example.
     */
    public function test_action_success(): void
    {
        $attendance_seed = Attendance::factory()->make();

        $attendance = [
            'name'          => $attendance_seed->name,
            'desc'          => $attendance_seed->desc,
            'price'         => $attendance_seed->price,
            'trackId'       => $attendance_seed->track_id,
        ];
        $resource = new CreateAttendanceRequest($attendance);

        $action = app(CreateAttendanceActionContract::class);
        $response = $action($resource);

        $this->assertInstanceOf(SuccessCreateAttendanceResource::class, $response);
    }
}
