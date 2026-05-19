<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PdfMonkeyService
{
    public function generateAppointmentPdf(array $data)
    {
        return Http::withoutVerifying() // ✅ ADD THIS LINE
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('PDFMONKEY_API_KEY'),
            ])->post('https://api.pdfmonkey.io/api/v1/documents', [
                'document' => [
                    'document_template_id' => env('PDFMONKEY_TEMPLATE_ID'),
                    'payload' => $data
                ]
            ])->json();
    }
}