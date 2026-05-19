<?php
namespace App\Http\Controllers;

use App\Services\PdfMonkeyService;

class PdfController extends Controller
{
    public function generatePDF(PdfMonkeyService $pdf)
    {
        return $pdf->generateAppointmentPdf([
            'name' => 'Ivan Sedoriosa',
            'appointment_date' => 'May 20, 2026',
            'service' => 'Dental Checkup'
        ]);
    }
}