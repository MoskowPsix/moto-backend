<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\PDFServiceContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google\Service\Exception;
use setasign\Fpdi\Tcpdf\Fpdi;
class RequestPdfController extends Controller
{
    protected PDFServiceContract $pdfService;
    public function __construct(PDFServiceContract $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'fields'            => 'nullable|array',
            'fields.*.x'        => 'nullable|numeric',
            'fields.*.y'        => 'nullable|numeric',
            'fields.*.width'    => 'nullable|numeric',
            'fields.*.height'   => 'nullable|numeric',
            'fields.*.value'    => 'nullable|string',
            'fields.*.align'    => 'nullable|string|in:L,C,R',
        ]);

        try{
            $outputPath = $this->pdfService->create($data['fields']);

            return response()->download($outputPath)->deleteFileAfterSend(true);
        }
        catch(Exception $e) {
            return response()->json(['error' => 'Failed to fill PDF', 'details' => $e->getMessage()], 500);
        }
    }

//    public function fillPDF(Request $request)
//    {
//        $data = $request->validate([
//            'RaceName'                  => 'nullable|string|',
//            'RaceAdr'                   => 'nullable|string',
//            'RaceDate'                  => 'nullable|date',
//            'RiderSurname'              => 'nullable|string',
//            'RiderName'                 => 'nullable|string',
//            'RiderPatronymic'           => 'nullable|string',
//            'Class'                     => 'nullable|string',
//            'Engine'                    => 'nullable|string',
//            'SensorNumber'              => 'nullable|string',
//            'StartNum'                  => 'nullable|string',
//            'data_birth'                => 'nullable|date',
//            'citizenship'               => 'nullable|string',
//            'region'                    => 'nullable|string',
//            'regionalCertificate'       => 'nullable|string',
//            'team'                      => 'nullable|string',
//
//            "firstMotoMark"             => 'nullable|string',
//            "firstMotoMarkNumber"       => 'nullable|string',
//            "firstMotoMarkYear"         => 'nullable|string',
//
//            "secondMotoMark"            => 'nullable|string',
//            "secondMotoMarkNumber"      => 'nullable|string',
//            "secondMotoMarkYear"        => 'nullable|string',
//
//            "Trener"                    => 'nullable|string',
//            "Mechanic"                  => 'nullable|string',
//
//            "serial_snils"              => 'nullable|string',
//            "whoGive"                   => 'nullable|string',
//            'period'                    => 'nullable|string',
//
//            "medDolusk"                 => 'nullable|string',
//            "serial_passport"           => 'nullable|string',
//            "whoWereGive"               => 'nullable|string',
//            "INN"                       => 'nullable|string',
//            'pensionCertificate'        => 'nullable|string',
//            "phoneNumber"               => 'nullable|string',
//        ]);
//
//        // Путь к шаблону PDF
//        $templatePath = public_path('pdf_templates/RequestShablon.pdf');
//
//        if (!file_exists($templatePath)) {
//            return response()->json(['error' => 'PDF template not found'], 404);
//        }
//
//        $pdf = new Fpdi();
//
//        // Загружаем шаблон PDF
//        $pageCount = $pdf->setSourceFile($templatePath);
//        $templateId = $pdf->importPage(1);
//        $pdf->AddPage();
//        $pdf->useImportedPage($templateId);
//
//        // Устанавливаем шрифт и размер текста
//        $pdf->SetFont('Arial', '', 12);
//        $pdf->SetTextColor(0, 0, 0);
//
//        $pdf->SetXY(12, 65);
//        $pdf->MultiCell(191, 5, $data['RaceName'], 0, 'C', true);
//
//        $pdf->SetXY(12, 70);
//        $pdf->MultiCell(138, 5, $data['RaceAdr'], 0, 'C', true);
//
//        $pdf->SetXY(150.5, 70);
//        $pdf->SetXY(150.5, 70);
//        $pdf->MultiCell(52, 5, $data['RaceDate'], 0, 'C', true);
//
//        $pdf->SetXY(12, 45);
//        $pdf->MultiCell(45, 12, $data['Class'], 0, 'C', true);
//
//        $pdf->SetXY(69, 45);
//        $pdf->MultiCell(38, 12, $data['Engine'], 0, 'C', true);
//
//        $pdf->SetXY(126, 45);
//        $pdf->MultiCell(34, 12, $data['SensorNumber'], 0, 'C', true);
//
//        $pdf->SetXY(173, 45);
//        $pdf->MultiCell(30, 12, $data['StartNum'], 0, 'C', true);
//
//        $pdf->SetXY(57.5, 77);
//        $pdf->MultiCell(145.5, 6, $data['RiderSurname'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 83);
//        $pdf->MultiCell(145.5, 6, $data['RiderName'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 89);
//        $pdf->MultiCell(145.5, 6, $data['RiderPatronymic'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 117);
//        $pdf->MultiCell(69, 4, $data['data_birth'], 0, 'L', true);
//
//        $pdf->SetXY(173, 117);
//        $pdf->MultiCell(30, 4, $data['citizenship'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 123);
//        $pdf->MultiCell(145.5, 6, $data['region'], 0, 'L', true);
//
//        $pdf->SetXY(38, 131);
//        $pdf->MultiCell(80, 5, $data['team'], 0, 'L', true);
//
//        $pdf->SetXY(173, 131);
//        $pdf->MultiCell(30, 5, $data['regionalCertificate'], 0, 'L', false);
//
//        $pdf->SetXY(88, 138);
//        $pdf->MultiCell(62, 5, $data['firstMotoMark'], 0, 'C', true);
//
//        $pdf->SetXY(150, 138);
//        $pdf->MultiCell(23, 5, $data['firstMotoMarkNumber'], 0, 'C', true);
//
//        $pdf->SetXY(173, 138);
//        $pdf->MultiCell(30, 5, $data['firstMotoMarkYear'], 0, 'C', true);
//
//        $pdf->SetXY(88, 143);
//        $pdf->MultiCell(62, 5, $data['secondMotoMark'], 0, 'C', true);
//
//        $pdf->SetXY(150, 143);
//        $pdf->MultiCell(23, 5, $data['secondMotoMarkNumber'], 0, 'C', true);
//
//        $pdf->SetXY(173, 143);
//        $pdf->MultiCell(30, 5, $data['secondMotoMarkYear'], 0, 'C', true);
//
//        $pdf->SetXY(107, 154);
//        $pdf->MultiCell(96, 4, $data['Trener'], 0, 'L', true);
//
//        $pdf->SetXY(107, 158.5);
//        $pdf->MultiCell(96, 4, $data['Mechanic'], 0, 'L', true);
//
//        $pdf->SetXY(88, 164);
//        $pdf->MultiCell(38, 5, $data['serial_passport'], 0, 'L', true);
//
//        $pdf->SetXY(170, 164);
//        $pdf->MultiCell(33, 5, $data['period'], 0, 'C', true);
//
//        $pdf->SetXY(88, 169.2);
//        $pdf->MultiCell(115, 4, $data['whoGive'], 0, 'L', true);
//
//        $pdf->SetXY(170, 175);
//        $pdf->MultiCell(33, 5, $data['medDolusk'], 0, 'C', true);
//
//        $pdf->SetXY(160.2, 180);
//        $pdf->MultiCell(42.5, 5, $data['serial_passport'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 184.5);
//        $pdf->MultiCell(145, 4.9, $data['whoWereGive'], 0, 'L', true);
//
//        $pdf->SetXY(57.5, 189);
//        $pdf->MultiCell(30.5, 4.7, $data['INN'], 0, 'L', true);
//
//        $pdf->SetXY(173, 189);
//        $pdf->MultiCell(30, 4.7, $data['pensionCertificate'], 0, 'L', true);
//
//        $pdf->SetXY(38, 205);
//        $pdf->MultiCell(88, 4.7, $data['phoneNumber'], 0, 'L', true);
//
//
//        $outputFileName = 'filled_template_' . time() . '.pdf';
//        $outputPath = storage_path("app/public/{$outputFileName}");
//
//        // Сохраняем заполненный PDF
//        $pdf->Output($outputPath, 'F');
//        return response()->download($outputPath)->deleteFileAfterSend(true);
//    }
}
