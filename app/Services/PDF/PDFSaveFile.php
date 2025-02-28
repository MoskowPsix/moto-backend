<?php

namespace App\Services\PDF;

use FPDF;
use setasign\Fpdi\Tcpdf\Fpdi;

class PDFSaveFile
{
    public function saveFile(Fpdi $pdf): string
    {
        $outputFileName = 'Document' . time() . '.pdf';
        $outputPath = storage_path("app/public/{$outputFileName}");

        // Сохраняем заполненный PDF
        $pdf->Output($outputPath, 'F');
        return $outputPath;
    }
}
