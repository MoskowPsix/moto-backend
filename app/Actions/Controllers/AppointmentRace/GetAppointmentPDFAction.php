<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\GetAppointmentPDFActionContract;
use App\Contracts\Services\PDFServiceContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use App\Services\PDF\PDFService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GetAppointmentPDFAction implements  GetAppointmentPDFActionContract
{
    private PDFServiceContract $pdfService;
//    public function __construct(private PDFServiceContract $pdfService)
//    {}
    public function __invoke($id): BinaryFileResponse|NotFoundResource
    {
        $app = AppointmentRace::find($id);
        if(empty($app)) {
            return NotFoundResource::make([]);
        }
        $this->pdfService = new PDFService();
        return $this->pdfService->create($app);
    }
}
