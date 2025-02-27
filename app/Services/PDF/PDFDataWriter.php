<?php

namespace App\Services\PDF;

use setasign\Fpdi\Tcpdf\Fpdi;

class PDFDataWriter
{
    protected Fpdi $pdf;

    public function __construct(Fpdi $pdf)
    {
        $this->pdf = $pdf;
    }
    //Запись данных
    public function writePDF(array $fields): void
    {
        foreach ($fields as $field) {
            $x = $field['x'] ?? 0;
            $y = $field['y'] ?? 0;
            $width = $field['width'] ?? 100;
            $height = $field['height'] ?? 5;
            $value = $field['value'] ?? '';
            $align = $field['align'] ?? 'L';

            if(!empty($value)){
                $this->pdf->SetXY($x, $y);
                $this->pdf->MultiCell($width, $height, $value, $align);
            }
        }
    }
}
