<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PdfController;


Route::middleware('auth:sanctum')->group(function () {

    // API 1 Users
    Route::get('/users', function () {
        $response = Http::get('https://jsonplaceholder.typicode.com/users');
        return $response->json();
    });

    // API 2 Calendly
    Route::get('/test-calendly', function () {
        $response = Http::withoutVerifying() // ✅ SSL Bypass
            ->withToken(env('CALENDLY_TOKEN'))
            ->get('https://api.calendly.com/users/me');
        return $response->json();
    });


    // API 3  Mail
    Route::get('/test-mail', function () {
        Mail::raw('SRAS Gmail SMTP test working!', function ($message) {
            $message->to('yourgmail@gmail.com')
                    ->subject('Test Email');
        });
        return response()->json(['message' => 'Email sent!']);
    });

    // API 4  Generate PDF
    Route::get('/generate-pdf', [PdfController::class, 'generatePDF']);

    // API 5 Notify
    Route::post('/notify', [NotificationController::class, 'send']);

});