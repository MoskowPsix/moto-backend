<?php

namespace App\Services\PDF;

use App\Contracts\Services\PDFServiceContract;
use App\Http\Resources\Errors\NotFoundResource;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Tcpdf\Fpdi;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\Filter\FilterException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;

class PDFService implements PDFServiceContract
{
    public string $templatePath;
    public function __construct()
    {
        $this->templatePath = public_path('pdf_templates/RequestShablon.pdf');
    }

    /**
     * @throws CrossReferenceException
     * @throws PdfReaderException
     * @throws PdfParserException
     * @throws PdfTypeException
     * @throws FilterException
     */
    public function create(array $fields): string|NotFoundResource
    {
        $pdfPathChecker = new PdfPathChecker($this->templatePath);
        if(!$pdfPathChecker->checkPath()){
            return new NotFoundResource([]);
        }

        $pdf = new Fpdi();

        $pdf->SetFont('freesans', '', 12);
        $pdf->SetTextColor(0, 0, 0);

        //Загружаем шаблон
        $pageCount = $pdf->setSourceFile($this->templatePath);
        $templateId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useImportedPage($templateId);

        //Запись данных
        $pdfDataWriter = new PdfDataWriter($pdf);
        $pdfDataWriter->writePDF($fields);

        //Сохранение
        $pdfSaveFile = new PDFSaveFile();

        return $pdfSaveFile->saveFile($pdf);
    }
}
