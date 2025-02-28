<?php

namespace App\Contracts\Services;

use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface PDFServiceContract
{
    public function create(AppointmentRace $fields): BinaryFileResponse;

}
