<?php

namespace App\Contracts\Actions\Controllers\AppointmentRace;

use App\Http\Resources\Errors\NotFoundResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface GetAppointmentPDFActionContract
{
    public function __invoke($id): BinaryFileResponse|NotFoundResource;

}
