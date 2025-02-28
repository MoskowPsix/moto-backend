<?php

namespace App\Services\PDF;

use App\Contracts\Services\PDFServiceContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;
use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PDFService implements PDFServiceContract
{
    public string $templatePath;
    public function __construct()
    {
        $this->templatePath = public_path('pdf_templates/RequestShablonS.pdf');
    }

    /**
     * @throws CrossReferenceException
     * @throws PdfReaderException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws FilterException
     */
    public function create(AppointmentRace $fields): BinaryFileResponse
    {
        $pdfPathChecker = new PdfPathChecker($this->templatePath);
        if(!$pdfPathChecker->checkPath()){
            throw new Exception('PDF path check failed');
        }

        $pdf = new Fpdi();

        $pdf->SetFont('freesans', '', 12);
        $pdf->SetTextColor(0, 0, 0);

        $pageCount = $pdf->setSourceFile($this->templatePath);
        $templateId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useImportedPage($templateId);

        //Запись данных
        $pdfDataWriter = new PdfDataWriter($pdf);
        $pdfDataWriter->writePDF($fields);

        $outputFileName = 'Document' . time() . '.pdf';
        $outputPath = storage_path("app/public/{$outputFileName}");

        $pdf->Output($outputPath, 'F');
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
